(function ($, window) {
    'use strict';
    $(window).on('elementor/frontend/init', function () {

        function RTSectionParallax($scope) {
            $scope.RTSectionParallaxInit();
            $scope.RTSectionParticlesInit();
            $scope.RTSectionParticlesImageInit();
            $scope.RTSectionShapeDividerInit();
        }

        window.elementorFrontend.hooks.addAction('frontend/element_ready/section', RTSectionParallax);

    });

    // Add RT Parallax Section
    $.fn.RTSectionParallaxInit = function (options) {
        var defaults = {};

        return this.each(function () {

            var self = $(this),
                rtParallax = {
                    editorMode: window.elementorFrontend.isEditMode(),
                    itemId: $(this).data('id'),
                    options: false,
                    globalVars: 'add_background_animation',
                    backEndVars: null,
                    items: [],
                };

            var init = function () {
                setParallaxItem();
            },
                setParallaxItem = function () {
                    var settings;

                    var checkEnabledParallax = parallaxEffectEnabled();

                    if (!checkEnabledParallax) {
                        return;
                    }

                    if (!rtParallax.editorMode) {
                        settings = buildFrontParallax();
                    } else {
                        settings = buildBackendParallax();
                    }

                    if (!settings) {
                        return;
                    }

                    build(settings);
                    hideMobile();

                },
                parallaxEffectEnabled = function () {
                    var settings = {};

                    if (!rtParallax.editorMode) {
                        settings = rt_parallax_settings[0][rtParallax.itemId];

                        if (!settings) {
                            return;
                        }

                        if (!settings.hasOwnProperty(rtParallax.globalVars) || !settings[rtParallax.globalVars]) {
                            return;
                        }
                    } else {
                        if (!window.elementor.elements) {
                            return;
                        }

                        if (!window.elementor.elements.models) {
                            return;
                        }

                        window.elementor.elements.models.forEach(function (value) {
                            if (rtParallax.itemId == value.id) {
                                rtParallax.backEndVars = value.attributes.settings.attributes;
                            }
                        });

                        if (!rtParallax.backEndVars) {
                            return;
                        }

                        if (!rtParallax.backEndVars.hasOwnProperty(rtParallax.globalVars) || !rtParallax.backEndVars[rtParallax.globalVars]) {
                            return;
                        }

                        settings = rtParallax.backEndVars;
                    }

                    return settings;
                },
                buildFrontParallax = function () {
                    var settings = rt_parallax_settings[0][rtParallax.itemId];
                    settings = settings['items_parallax'];
                    return settings;
                },
                buildBackendParallax = function () {

                    if (!window.elementor.elements.models) {
                        return;
                    }

                    var arr = [];

                    if (!rtParallax.backEndVars.hasOwnProperty('items_parallax')) {
                        return false;
                    }

                    rtParallax.backEndVars['items_parallax'].models.forEach(function (value) {
                        arr.push(value.attributes);
                    });

                    return arr;
                },
                appendElement = function (settings) {
                    var node_str = '';

                    if (settings.image_bg.url) {
                        node_str = '<div data-item-id="' + settings._id + '" class="extended-parallax elementor-repeater-item-' + settings._id + '">';
                        node_str += '<img  src="' + settings.image_bg.url + '"/>';
                        node_str += '</div>';
                    }

                    if (!$(self).find('.elementor-repeater-item-' + settings._id).length > 0) {
                        $(self).append(node_str);
                    }

                    rtParallax.items.push(settings);

                    var item = jQuery(self).find('.extended-parallax');
                    if (item.length !== 0) {
                        item.each(function () {
                            if (settings._id == jQuery(this).data('itemId')) {
                                if (settings.image_effect == 'mouse') {
                                    if (!jQuery(this).closest('.elementor-section').hasClass('rt-parallax-mouse')) {
                                        jQuery(this).closest('.elementor-section').addClass('rt-parallax-mouse');
                                    }

                                    jQuery(this).wrapInner('<div class="rt-parallax-layer layer" data-depth="' + settings.parallax_factor + '"></div>');
                                } else if (settings.image_effect == 'scroll') {
                                    if (rtParallax.editorMode) {
                                        jQuery(this).paroller({
                                            factor: settings.parallax_factor,
                                            type: 'foreground',     // background, foreground  
                                            direction: settings.parallax_dir, // vertical, horizontal  

                                        });
                                        jQuery(this).css({ 'transform': 'unset' });
                                    } else {
                                        jQuery(this).paroller({
                                            factor: settings.parallax_factor,
                                            type: 'foreground',     // background, foreground  
                                            direction: settings.parallax_dir, // vertical, horizontal  

                                        });
                                    }
                                } else if (settings.image_effect == 'css_animation') {
                                    var self = $(this);

                                    if (self.is_visible()) {
                                        self.addClass(settings.animation_name);
                                    }
                                    jQuery(window).on('resize scroll', function () {
                                        if (self.is_visible()) {
                                            self.addClass(settings.animation_name);
                                        }
                                    });
                                }
                            }
                        });

                        if (settings.image_effect == 'mouse') {
                            jQuery('.rt-parallax-mouse').each(function () {
                                var scene = jQuery(this).get(0);
                                var parallaxInstance = new Parallax(scene, { hoverOnly: true, selector: '.rt-parallax-layer', pointerEvents: true });
                            });
                        }
                    }
                },
                hideMobile = function () {
                    if (rtParallax.items) {
                        $.each(rtParallax.items, function (index, value) {
                            if (value.hide_on_mobile) {
                                if (jQuery(window).width() <= value.hide_mobile_resolution) {
                                    jQuery('.extended-parallax[data-item-id="' + value._id + '"]').css({ 'opacity': '0', 'visibility': 'hidden' });
                                } else {
                                    jQuery('.extended-parallax[data-item-id="' + value._id + '"]').css({ 'opacity': '1', 'visibility': 'visible' });
                                }
                            }
                        });
                    }
                },
                build = function (settings) {
                    $.each(settings, function (index, value) {
                        appendElement(value);
                    });


                };

            /*Init*/
            init();

            jQuery(window).resize(
                function () {
                    hideMobile();
                }
            );
        });
    };

    // Add RT Particles Animation
    $.fn.RTSectionParticlesInit = function (options) {
        var defaults = {};

        return this.each(function () {

            var self = $(this),
                rtParallax = {
                    editorMode: window.elementorFrontend.isEditMode(),
                    itemId: $(this).data('id'),
                    options: false,
                    globalVars: 'add_particles_animation',
                    backEndVars: null,
                    items: [],
                };

            var init = function () {
                setParallaxItem();
            },
                setParallaxItem = function () {
                    var settings;

                    var checkEnabledParallax = parallaxEffectEnabled();

                    if (!checkEnabledParallax) {
                        return;
                    }

                    if (!rtParallax.editorMode) {
                        settings = buildFrontParallax();
                    } else {
                        settings = buildBackendParallax();
                    }

                    if (!settings) {
                        return;
                    }

                    build(settings);
                    hideMobile();

                },
                parallaxEffectEnabled = function () {
                    var settings = {};

                    if (!rtParallax.editorMode) {
                        settings = rt_parallax_settings[0][rtParallax.itemId];

                        if (!settings) {
                            return;
                        }

                        if (!settings.hasOwnProperty(rtParallax.globalVars) || !settings[rtParallax.globalVars]) {
                            return;
                        }
                    } else {
                        if (!window.elementor.elements) {
                            return;
                        }

                        if (!window.elementor.elements.models) {
                            return;
                        }

                        window.elementor.elements.models.forEach(function (value) {
                            if (rtParallax.itemId == value.id) {
                                rtParallax.backEndVars = value.attributes.settings.attributes;
                            }
                        });

                        if (!rtParallax.backEndVars) {
                            return;
                        }

                        if (!rtParallax.backEndVars.hasOwnProperty(rtParallax.globalVars) || !rtParallax.backEndVars[rtParallax.globalVars]) {
                            return;
                        }

                        settings = rtParallax.backEndVars;
                    }

                    return settings;
                },
                buildFrontParallax = function () {
                    var settings = rt_parallax_settings[0][rtParallax.itemId];
                    settings = settings['items_particles'];
                    return settings;
                },
                buildBackendParallax = function () {

                    if (!window.elementor.elements.models) {
                        return;
                    }

                    var arr = [];

                    if (!rtParallax.backEndVars.hasOwnProperty('items_particles')) {
                        return false;
                    }

                    rtParallax.backEndVars['items_particles'].models.forEach(function (value) {
                        arr.push(value.attributes);
                    });

                    return arr;
                },
                appendElement = function (settings) {
                    var node_str = '',
                    $data_attr = '',
                    $style_attr = '';

                    $data_attr += ' data-particles-colors-type="' + settings.particles_effect + '"';
                    $data_attr += ' data-particles-number="' + settings.particles_count + '"';
                    $data_attr += ' data-particles-size="' + settings.particles_max_size + '"';
                    $data_attr += ' data-particles-speed="' + settings.particles_speed + '"';
                    
                    if(settings.particles_line){
                        $data_attr += ' data-particles-line="true"';
                    }else{
                        $data_attr += ' data-particles-line="false"';
                    }

                    if(settings.particles_hover_animation === 'none'){
                        $data_attr += ' data-particles-hover="false"';
                        $data_attr += ' data-particles-hover-mode="grab"';
                    }else{
                        $data_attr += ' data-particles-hover="true"';
                        $data_attr += ' data-particles-hover-mode="' + settings.particles_hover_animation + '"';
                    }

                    if(settings.particles_effect !== 'random_colors'){
                        if(settings.particles_color_one){
                            $data_attr += ' data-particles-color="' + settings.particles_color_one + '"';
                        }
                    }else{
                        var $color_array = '';
                        
                        if(settings.particles_color_one){
                            $color_array += settings.particles_color_one;
                        } 
                        if(settings.particles_color_second){
                            $color_array += ',' + settings.particles_color_second;
                        } 
                        if(settings.particles_color_third){
                            $color_array += ',' + settings.particles_color_third;
                        } 

                        $data_attr += ' data-particles-color="' + $color_array + '"';
                    }

                    $data_attr += ' data-particles-type="particles"';
                    
                    var style_array = ''
                    style_array += 'width:' + settings.particles_width + '%; ';
                    style_array += 'height:' + settings.particles_height + '%;';
                   
                    $style_attr += ' style="' + style_array + '"';  

                    node_str = '<div id="extended_' + settings._id + '" data-item-id="' + settings._id + '" class="rt-particles-js particles-js elementor-repeater-item-' + settings._id + '"' + $data_attr + $style_attr + '>';
                    node_str += '</div>'; 

                   
                    if (!$(self).find('.elementor-repeater-item-' + settings._id).length > 0) {
                        $(self).append(node_str); 
                    }

                    var itemContainer = $(self).get(0);
                    $(itemContainer).addClass("rt-row-animation");

                    rtParallax.items.push(settings);

                    var item = jQuery(self).find('.rt-particles-js');
                    if (item.length !== 0) {
                        item.each(function () {
                            if (settings._id == jQuery(this).data('itemId')) {
                                //Call Particles RT Theme
                                if(rtParallax.editorMode){
                                    gostudy_particles_custom();
                                }
                            }
                        });
                    }
                },
                hideMobile = function () {
                    if (rtParallax.items) {
                        $.each(rtParallax.items, function (index, value) {
                            if (value.hide_particles_on_mobile) {
                                if (jQuery(window).width() <= value.hide_particles_mobile_resolution) {
                                    jQuery('.rt-particles-js[data-item-id="' + value._id + '"]').css({ 'opacity': '0', 'visibility': 'hidden' });
                                } else {
                                    jQuery('.rt-particles-js[data-item-id="' + value._id + '"]').css({ 'opacity': '1', 'visibility': 'visible' });
                                }
                            }
                        });
                    }
                },
                build = function (settings) {
                    $.each(settings, function (index, value) {
                        appendElement(value);
                    });


                };

            /*Init*/
            init();

            jQuery(window).resize(
                function () {
                    hideMobile();
                }
            );
        });
    };
    
    // Add RT Particles Image Animation
    $.fn.RTSectionParticlesImageInit = function (options) {
        var defaults = {};

        return this.each(function () {

            var self = $(this),
                rtParallax = {
                    editorMode: window.elementorFrontend.isEditMode(),
                    itemId: $(this).data('id'),
                    options: false,
                    globalVars: 'add_particles_img_animation',
                    backEndVars: null,
                    items: [],
                };

                var init = function () {
                    setParallaxItem();
                },
                setParallaxItem = function () {
                    var settings;

                    var checkEnabledParallax = parallaxEffectEnabled();

                    if (!checkEnabledParallax) {
                        return;
                    }

                    if (!rtParallax.editorMode) {
                        settings = buildFrontParallax();
                    } else {
                        settings = buildBackendParallax();
                    }

                    if (!settings.length) {
                        return;
                    }

                    build(settings);
                    hideMobile();

                },
                parallaxEffectEnabled = function () {
                    var settings = {};

                    if (!rtParallax.editorMode) {
                        settings = rt_parallax_settings[0][rtParallax.itemId];

                        if (!settings) {
                            return;
                        }

                        if (!settings.hasOwnProperty(rtParallax.globalVars) || !settings[rtParallax.globalVars]) {
                            return;
                        }
                    } else {
                        if (!window.elementor.elements) {
                            return;
                        }

                        if (!window.elementor.elements.models) {
                            return;
                        }

                        window.elementor.elements.models.forEach(function (value) {
                            if (rtParallax.itemId == value.id) {
                                rtParallax.backEndVars = value.attributes.settings.attributes;
                            }
                        });

                        if (!rtParallax.backEndVars) {
                            return;
                        }

                        if (!rtParallax.backEndVars.hasOwnProperty(rtParallax.globalVars) || !rtParallax.backEndVars[rtParallax.globalVars]) {
                            return;
                        }

                        settings = rtParallax.backEndVars;
                    }

                    return settings;
                },
                buildFrontParallax = function () {
                    var settings = rt_parallax_settings[0][rtParallax.itemId];
                    rtParallax.backEndVars = settings;
                    settings = settings['items_particles_img'];
                    return settings;
                },
                buildBackendParallax = function () {

                    if (!window.elementor.elements.models) {
                        return;
                    }

                    var arr = [];

                    if (!rtParallax.backEndVars.hasOwnProperty('items_particles_img')) {
                        return false;
                    }

                    rtParallax.backEndVars['items_particles_img'].models.forEach(function (value) {
                        arr.push(value.attributes);
                    });

                    return arr;
                },
                appendElement = function (settings, uniqId) {

                    var node_str = '',
                    $data_attr = '',
                    $style_attr = '';

                    $data_attr += ' data-particles-number="' + rtParallax.backEndVars.particles_img_count + '"';
                    $data_attr += ' data-particles-speed="' + rtParallax.backEndVars.particles_img_speed + '"';
                    $data_attr += ' data-particles-color="' + rtParallax.backEndVars.particles_img_color + '"';
                    $data_attr += ' data-particles-size="' + rtParallax.backEndVars.particles_img_max_size + '"';
                    $data_attr += ' data-particles-rotate="' + rtParallax.backEndVars.particles_img_rotate + '"';
                    $data_attr += ' data-particles-rotate-animation="' + rtParallax.backEndVars.particles_img_rotate_speed + '"';
                    
                    if(rtParallax.backEndVars.particles_img_line){
                        $data_attr += ' data-particles-line="true"';
                    }else{
                        $data_attr += ' data-particles-line="false"';
                    }

                    if(rtParallax.backEndVars.particles_img_hover_animation === "none"){
                        $data_attr += ' data-particles-hover="false"';
                        $data_attr += ' data-particles-hover-mode="grab"';
                    }else{
                        $data_attr += ' data-particles-hover="true"';
                        $data_attr += ' data-particles-hover-mode="' + rtParallax.backEndVars.particles_img_hover_animation + '"';
                    }

                    $data_attr += ' data-particles-type="image"';
                    
                    var style_array = ''
                    style_array += 'width:' + rtParallax.backEndVars.particles_img_container_width + '%; ';
                    style_array += 'height:' + rtParallax.backEndVars.particles_img_container_height + '%;';
                   
                    $style_attr += ' style="' + style_array + '"';  

                    var $string_url = [];
                    $.each(settings, function (index, value) { 
                        $string_url.push(value.particles_image.url + '?width=' + value.particles_img_width + '&height=' + value.particles_img_height);
                    }); 

                    $data_attr += ' data-image="' + $string_url.join()  + '"';

                    node_str = '<div id="extended_' + uniqId + '" data-item-id="' + uniqId + '" class="rt-particles-img-js particles-js elementor-repeater-item-' + uniqId + '"' + $data_attr + $style_attr + '>';                    
                    node_str += '</div>'; 

                    if (!$(self).find('.elementor-repeater-item-' + uniqId).length > 0) {
                        $(self).append(node_str); 
                    }

                    var itemContainer = $(self).get(0);
                    $(itemContainer).addClass("rt-row-animation");

                    rtParallax.backEndVars.__itemID = uniqId;

                    var item = jQuery(self).find('.rt-particles-img-js');

                    if (item.length !== 0) {
                        if(rtParallax.editorMode){
                            gostudy_particles_image_custom();
                        }
                    }
                },
                hideMobile = function () {
                    if (rtParallax.backEndVars) {
                        if (rtParallax.backEndVars.hide_particles_img_on_mobile) {
                            if (jQuery(window).width() <= rtParallax.backEndVars.hide_particles_img_mobile_resolution) {
                                jQuery('.rt-particles-img-js[data-item-id="' + rtParallax.backEndVars.__itemID + '"]').css({ 'opacity': '0', 'visibility': 'hidden' });
                            } else {
                                jQuery('.rt-particles-img-js[data-item-id="' + rtParallax.backEndVars.__itemID + '"]').css({ 'opacity': '1', 'visibility': 'visible' });
                            }
                        }

                    }
                },
                build = function (settings) {
                    var uniqId = Math.random().toString(36).substr(2, 9);
                    appendElement(settings, uniqId);
                };

            /*Init*/
            init();

            jQuery(window).resize(
                function () {
                    hideMobile();
                }
            );
        });
    };

    // Add RT Shape Divider
    $.fn.RTSectionShapeDividerInit = function (options) {
        var defaults = {};

        return this.each(function () {

            var self = $(this),
                rtShapeDivider = {
                    editorMode: window.elementorFrontend.isEditMode(),
                    itemId: $(this).data('id'),
                    options: false,
                    globalVars: 'add_shape_divider',
                    backEndVars: [],
                    items: [],
                };

            var init = function () {
                setShapeDividerItem();
            },
                setShapeDividerItem = function () {
                    var settings;

                    var checkEnabledParallax = ShapeDividerEnabled();

                    if (!checkEnabledParallax) {
                        return;
                    }

                    if (!rtShapeDivider.editorMode) {
                        settings = buildFrontShapeDivider();
                    } else {
                        settings = buildBackendShapeDivider();
                    }

                    if (!settings) {
                        return;
                    }

                    build(settings);

                },
                ShapeDividerEnabled = function () {
                    var settings = {};

                    if (!rtShapeDivider.editorMode) {
                        settings = rt_parallax_settings[0][rtShapeDivider.itemId];

                        if (!settings) {
                            return;
                        }

                    } else {
                        if (!window.elementor.elements) {
                            return;
                        }

                        if (!window.elementor.elements.models) {
                            return;
                        }

                        window.elementor.elements.models.forEach(function (value) {
                            if (rtShapeDivider.itemId == value.id) {
                                rtShapeDivider.backEndVars[rtShapeDivider.itemId] = value.attributes.settings.attributes;
                                settings = value.attributes.settings.attributes;
                            }
                        });
                    }

                    return settings;
                },
                buildFrontShapeDivider = function () {
                    var settings = rt_parallax_settings[0];
                    return settings;
                },

                buildBackendShapeDivider = function () {

                    if (!window.elementor.elements.models) {
                        return;
                    }

                    var arr = [];

                    arr = rtShapeDivider.backEndVars;

                    return arr;
                },

                getSvgURL = function (fileName) {
                    var svgURL = rt_parallax_settings.svgURL + fileName + '.svg';

                    return svgURL;
                },

                appendElement = function (settings) {

                    var $item = settings[$(self).data('id')];

                    if (!$item) {
                        return;
                    }

                    var node_str = '',
                        svgURL = '';

                    if ($item.rt_shape_divider_top !== '') {

                        svgURL = getSvgURL($item.rt_shape_divider_top);

                        node_str = '<div class="rt-divider rt-elementor-shape rt-elementor-shape-top"></div>';
                        $(self).prepend(node_str);

                        jQuery.get(svgURL, function (data) {
                            $(self).find('.rt-divider.rt-elementor-shape-top').empty().append(data.childNodes[0]);
                        });
                    }

                    if ($item.rt_shape_divider_bottom !== '') {

                        svgURL = getSvgURL($item.rt_shape_divider_bottom);

                        node_str = '<div class="rt-divider rt-elementor-shape rt-elementor-shape-bottom"></div>';
                        $(self).prepend(node_str);

                        jQuery.get(svgURL, function (data) {
                            $(self).find('.rt-divider.rt-elementor-shape-bottom').empty().append(data.childNodes[0]);
                        });
                    }
                },

                build = function (settings) {
                    appendElement(settings);
                };

            /*Init*/
            init();

        });
    };

}(jQuery, window));


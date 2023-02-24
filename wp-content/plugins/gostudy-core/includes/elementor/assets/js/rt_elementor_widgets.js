(function ($) {
    "use strict";

      // Image hover parallaxed effect
        var b = document.getElementsByTagName("BODY")[0];  

        b.addEventListener("mousemove", function(event) {
          parallaxed(event);

        });

        function parallaxed(e) {
              var amountMovedX = (e.clientX * -0.2 / 9);
              var amountMovedY = (e.clientY * -0.2 / 9);
              var x = document.getElementsByClassName("parallaxed");
              var i;
              for (i = 0; i < x.length; i++) {
                x[i].style.transform='translate(' + amountMovedX + 'px,' + amountMovedY + 'px)'
              }
        }


    // Elementor/frontend/init

    jQuery(window).on('elementor/frontend/init', function () {
        if (window.elementorFrontend.isEditMode()) {
            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-blog.default',
                function ($scope) {
                    gostudy_parallax_video();
                    gostudy_blog_masonry_init();
                    gostudy_carousel_slick();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-blog-hero.default',
                function ($scope) {
                    gostudy_parallax_video();
                    gostudy_blog_masonry_init();
                    gostudy_carousel_slick();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-carousel.default',
                function ($scope) {
                    gostudy_carousel_slick();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-portfolio.default',
                function ($scope) {
                    gostudy_isotope();
                    gostudy_carousel_slick();
                    gostudy_scroll_animation();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-gallery.default',
                function ($scope) {
                    gostudy_images_gallery();
                    gostudy_carousel_slick();
                    gostudy_scroll_animation();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-progress-bar.default',
                function ($scope) {
                    gostudy_progress_bars_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-testimonials.default',
                function ($scope) {
                    gostudy_carousel_slick();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-slider.default',
                function ($scope) {
                    gostudy_carousel_slick();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-toggle-accordion.default',
                function ($scope) {
                    gostudy_accordion_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-accordion-service.default',
                function ($scope) {
                    gostudy_services_accordion_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-team.default',
                function ($scope) {
                    gostudy_isotope();
                    gostudy_carousel_slick();
                    gostudy_scroll_animation();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-tabs.default',
                function ($scope) {
                    gostudy_tabs_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-clients.default',
                function ($scope) {
                    gostudy_carousel_slick();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-testimonial.default',
                function ($scope) {
                    gostudy_carousel_slick();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-image-layers.default',
                function ($scope) {
                    gostudy_img_layers();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-video-popup.default',
                function ($scope) {
                    gostudy_videobox_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-countdown.default',
                function ($scope) {
                    gostudy_countdown_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-time-line-vertical.default',
                function ($scope) {
                    gostudy_init_timeline_appear();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-striped-services.default',
                function ($scope) {
                    gostudy_striped_services_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-image-comparison.default',
                function ($scope) {
                    gostudy_image_comparison();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-circuit-service.default',
                function ($scope) {
                    gostudy_circuit_service();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-counter.default',
                function ($scope) {
                    gostudy_counter_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-menu.default',
                function ($scope) {
                    gostudy_menu_lavalamp();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-header-search.default',
                function ($scope) {
                    gostudy_search_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-header-side_panel.default',
                function ($scope) {
                    gostudy_side_panel_init();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-courses.default',
                function($scope) {
                    gostudy_carousel_slick();
                    gostudy_isotope();
                }
            );

            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/rt-courses-alt.default',
                function($scope) {
                    gostudy_carousel_slick();
                    gostudy_isotope();
                }
            );
           // window.elementorFrontend.hooks.addAction('frontend/element_ready/rt-slider.default', function($scope) { gostudy_slider_slick(); });
            //window.elementorFrontend.hooks.addAction('frontend/element_ready/rt-slider.default', WidgetEdubinSliderHandler);
        }
    });

})(jQuery);

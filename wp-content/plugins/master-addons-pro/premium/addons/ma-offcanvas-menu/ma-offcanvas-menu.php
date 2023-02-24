<?php

namespace MasterAddons\Addons;

// Elementor Classes
use \Elementor\Widget_Base;
use Elementor\Core\Base\Document;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use \Elementor\Icons_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Repeater;
use \Elementor\Core\Schemes\Color;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// Master Addons Class
use MasterAddons\Inc\Controls\JLTMA_Control_Choose_Text;
use MasterAddons\Inc\Helper\Master_Addons_Helper;
use MasterAddons\Inc\Controls\MA_Group_Control_Transition;

/**
 * Author Name: Liton Arefin
 * Author URL : https://master-addons.com
 * Date       : 07/09/21
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Master Addons: Off Canvas Menu
 */
class JLTMA_Offcanvas_Menu extends Widget_Base
{
    private $box_to_down_count = 0;

    public function get_name()
    {
        return 'jltma-offcanvas-menu';
    }

    public function get_title()
    {
        return __('Off Canvas Menu', 'master-addons' );
    }

    public function get_categories()
    {
        return ['master-addons'];
    }

    public function get_icon()
    {
        return 'jltma-icon eicon-sidebar';
    }

    public function get_script_depends()
    {
        return ['jltma-offcanvas-menu'];
    }

    public function get_keywords()
    {
        return [
            'offcanvas',
            'off-canvas',
            'canvas',
            'navigation',
            'nav',
            'menu',
            'template',
            'page',
            'section',
            'block',
        ];
    }

    public function get_help_url()
    {
        return 'https://master-addons.com/demos/offcanvas-menu/';
    }

    public function get_widget_selector()
    {
        return '.' . $this->get_widget_class();
    }

    public function get_widget_class()
    {
        return 'jltma-offcanvas-menu';
    }

    public function get_sidebars($type)
    {
        global $wp_registered_sidebars;
        $new_arr = [];
        if( !empty($wp_registered_sidebars) ){
            foreach( $wp_registered_sidebars as $item ){
                $new_arr[ $item['id'] ] = $item['name'];
            }
        }else{
            $new_arr['not_found'] = __( 'No sidebars were found', 'master-addons' );
        }
        if( $type == 'default_key' ){
            return array_key_first( $new_arr );
        }
        return $new_arr;
    }

    protected function jltma_offcanvas_general_section()
    {
        $widget_selector = $this->get_widget_selector();

        $this->start_controls_section(
            'section_general',
            ['label' => __('General', JLTMA)]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label'              => __('Title', 'master-addons' ),
                'type'               => Controls_Manager::TEXT,
                'dynamic'            => ['active' => true],
                'frontend_available' => true,
            ]
        );

        $content_types = [
            'logo'       => __('Site Logo', 'master-addons' ),
            'custom'     => __('Custom Content', 'master-addons' ),
            'navigation' => __('Navigation', 'master-addons' ),
            'sidebar'    => __('Sidebar', 'master-addons' ),
            'section'    => __('Saved Section', 'master-addons' ),
            'template'   => __('Saved Page Template', 'master-addons' ),
        ];

        if (Master_Addons_Helper::is_elementor_pro()) {
            $content_types['widget'] = __('Global Widget', 'master-addons' );
        }

        $repeater->add_control(
            'content_type',
            [
                'label'   => __('Content Type', 'master-addons' ),
                'type'    => Controls_Manager::SELECT,
                'options' => $content_types,
                'default' => 'logo',
            ]
        );


        // $this->add_group_control(
        //     MA_Group_Control_Transition::get_type(),
        //     [
        //         'name'             => 'arrows',
        //         'selector'         => '{{WRAPPER}} .jltma-swiper__button',
        //         'condition'        => [
        //             'ma_el_blog_carousel_arrows'     => 'yes',
        //         ]
        //     ]
        // );

        $repeater->add_control(
            'logo_image_source',
            [
                'label'   => __('Source', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'default' => __('Website Logo', 'master-addons' ),
                    'custom'  => __('Custom Image', 'master-addons' ),
                ],
                'default'     => 'default',
                'label_block' => false,
                'condition'   => ['content_type' => 'logo'],
            ]
        );


        $repeater->add_control(
            'logo_type',
            [
                'label'   => __('Type', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'image' => [
                        'title'       => __('Image', 'master-addons' ),
                        'description' => __('Show only Image', 'master-addons' ),
                    ],
                    'text' => [
                        'title'       => __('Text', 'master-addons' ),
                        'description' => __('Show only Text', 'master-addons' ),
                    ],
                ],
                'default'      => 'image',
                'label_block'  => false,
                'prefix_class' => 'jltma-logo-type-',
                'render_type'  => 'template',
                'condition'    => [
                    'content_type'      => 'logo',
                    'logo_image_source' => 'custom',
                ],
            ]
        );

        $repeater->add_control(
            'logo_image',
            [
                'label'     => __('Image', 'master-addons' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'content_type'      => 'logo',
                    'logo_image_source' => 'custom',
                    'logo_type'         => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'logo_image_retina',
            [
                'label'     => esc_html__('Retina Logo Image', 'master-addons' ),
                'type'      => Controls_Manager::POPOVER_TOGGLE,
                'condition' => [
                    'content_type'      => 'logo',
                    'logo_image_source' => 'custom',
                    'logo_type'         => 'image',
                    'logo_image[id]!'   => '',
                ],
            ]
        );

        $repeater->start_popover();

        $repeater->add_control(
            'logo_image_2x',
            [
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'content_type'      => 'logo',
                    'logo_image_source' => 'custom',
                    'logo_type'         => 'image',
                    'logo_image[id]!'   => '',
                    'logo_image_retina' => 'yes',
                ],
            ]
        );

        $repeater->end_popover();


        $repeater->add_control(
            'logo_title',
            [
                'label'       => __('Title', 'master-addons' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => get_bloginfo('name'),
                'label_block' => false,
                'condition'   => [
                    'content_type'      => 'logo',
                    'logo_image_source' => 'custom',
                    'logo_type'         => 'text',
                ],
            ]
        );

        $repeater->add_control(
            'logo_link',
            [
                'label'   => __('Link', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'none' => [
                        'title' => __('None', 'master-addons' ),
                    ],
                    'home' => [
                        'title' => __('Home', 'master-addons' ),
                    ],
                    'custom' => [
                        'title' => __('Custom', 'master-addons' ),
                    ],
                ],
                'default'     => 'home',
                'label_block' => false,
                'render_type' => 'template',
                'condition'   => ['content_type' => 'logo'],
            ]
        );

        $repeater->add_control(
            'logo_custom_url',
            [
                'label'       => __('Custom Logo Url', 'master-addons' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => ['active' => true],
                'placeholder' => __('https://your-link.com', 'master-addons' ),
                'condition'   => ['logo_link' => 'custom'],
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label'     => __('Description', 'master-addons' ),
                'type'      => Controls_Manager::WYSIWYG,
                'dynamic'   => ['active' => true],
                'default'   => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'master-addons' ),
                'condition' => ['content_type' => 'custom'],
            ]
        );

        $menus = $this->get_available_menus();

        if (!empty($menus)) {
            $repeater->add_control(
                'nav_menu',
                [
                    'label'        => __('Select Menu', 'master-addons' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys($menus)[0],
                    'save_default' => true,
                    'description'  => /* translators: %s: Admin Url. */ sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'master-addons' ), admin_url('nav-menus.php')),
                    'condition'    => ['content_type' => 'navigation'],
                ]
            );
        } else {
            $repeater->add_control(
                'nav_menu',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => /* translators: %s: Admin Url. */ sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'master-addons' ), admin_url('nav-menus.php?action=edit&menu=0')),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    'condition'       => ['content_type' => 'navigation'],
                ]
            );
        }

        global $wp_registered_sidebars;

        if ($wp_registered_sidebars) {
            $repeater->add_control(
                'sidebar',
                [
                    'label'     => __('Choose Sidebar', 'master-addons' ),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => $this->get_sidebars('default_key'),
                    'options'   => $this->get_sidebars('options'),
                    'condition' => ['content_type' => 'sidebar'],
                ]
            );
        } else {
            $repeater->add_control(
                'sidebar',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => __('No sidebars were found.', 'master-addons' ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    'condition'       => ['content_type' => 'sidebar'],
                ]
            );
        }

        if (!array_key_exists('no_template', Master_Addons_Helper::ma_get_page_templates('section'))) {
            $repeater->add_control(
                'saved_section',
                [
                    'label'        => __('Choose Section', 'master-addons' ),
                    'label_block'  => true,
                    'show_label'   => false,
                    'type'         => 'jltma_query',
                    'autocomplete' => [
                        'object' => 'library_template',
                        'query'  => [
                            'meta_query' => [
                                [
                                    'key'   => Document::TYPE_META_KEY,
                                    'value' => 'section',
                                ],
                            ],
                        ],
                    ],
                    'condition' => ['content_type' => 'section'],
                ]
            );
        } else {
            $repeater->add_control(
                'saved_section',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => /* translators: %s: Admin Url. */ sprintf(__('<strong>There are no saved sections in your site.</strong><br>Go to the <a href="%s" target="_blank">Saved Section</a> to create one.', 'master-addons' ), admin_url('edit.php?post_type=elementor_library&tabs_group=library&elementor_library_type=section')),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    'condition' => ['content_type' => 'section'],
                ]
            );
        }

        if (!array_key_exists('no_template', Master_Addons_Helper::ma_get_page_templates('page'))) {
            $repeater->add_control(
                'template_id',
                [
                    'label'        => __('Choose Template', 'master-addons' ),
                    'label_block'  => true,
                    'show_label'   => false,
                    'type'         => 'jltma_query',
                    'autocomplete' => [
                        'object' => 'library_template',
                        'query'  => [
                            'meta_query' => [
                                [
                                    'key'   => Document::TYPE_META_KEY,
                                    'value' => 'page',
                                ],
                            ],
                        ],
                    ],
                    'condition' => ['content_type' => 'template'],
                ]
            );
        } else {
            $repeater->add_control(
                'template_id',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => /* translators: %s: Admin Url. */ sprintf(__('<strong>There are no templates in your site.</strong><br>Go to the <a href="%s" target="_blank">Saved Templates</a> to create one.', 'master-addons' ), admin_url('edit.php?post_type=elementor_library&tabs_group=library&elementor_library_type=page')),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                    'condition'       => ['content_type' => 'template'],
                ]
            );
        }

        if (!array_key_exists('no_template', Master_Addons_Helper::ma_get_page_templates('widget'))) {
            $repeater->add_control(
                'saved_widget',
                [
                    'label'        => __('Choose Widget', 'master-addons' ),
                    'label_block'  => true,
                    'show_label'   => false,
                    'type'         => 'jltma_query',
                    'autocomplete' => [
                        'object' => 'library_template',
                        'query'  => [
                            'meta_query' => [
                                [
                                    'key'   => Document::TYPE_META_KEY,
                                    'value' => 'widget',
                                ],
                            ],
                        ],
                    ],
                    'export'    => false,
                    'condition' => ['content_type' => 'widget'],
                ]
            );
        } else {
            $repeater->add_control(
                'saved_widget',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => /* translators: %s: Admni Url. */ sprintf(__('<strong>There are no saved global widgets in your site.</strong><br>Go to the <a href="%s" target="_blank">Global Widget</a> to create one.', 'master-addons' ), admin_url('edit.php?post_type=elementor_library&tabs_group=library&elementor_library_type=widget')),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    'condition' => ['content_type' => 'widget'],
                ]
            );
        }

        $repeater->add_control(
            'offcanvas_item_style',
            [
                'label' => esc_html__('Style', 'master-addons' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
            ]
        );

        $repeater->start_popover();

        $repeater->add_responsive_control(
            'offcanvas_alignment',
            [
                'label'     => __('Alignment', 'master-addons' ),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'center',
                'options'   => Master_Addons_Helper::jltma_content_alignment(),
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} {{CURRENT_ITEM}} ' . $widget_selector . '__custom-container-cont-inner' => 'text-align: {{VALUE}};',
                ],
                'condition' => ['offcanvas_item_style' => 'yes'],
            ]
        );

        $repeater->add_responsive_control(
            'offcanvas_padding',
            [
                'label' => __('Padding', 'master-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} {{CURRENT_ITEM}} ' . $widget_selector . '__custom-container-cont-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['offcanvas_item_style' => 'yes'],
            ]
        );

        $repeater->add_responsive_control(
            'content_margin_bottom',
            [
                'label'      => __('Gap Between', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors'  => [
                    '.jltma-offcanvas-content-{{ID}} {{CURRENT_ITEM}} ' . $widget_selector . '__custom-container-cont' => 'margin-top: calc( {{SIZE}}{{UNIT}} / 2 ); padding-top: calc( {{SIZE}}{{UNIT}} / 2 );',
                ],
                'condition' => ['offcanvas_item_style' => 'yes'],
            ]
        );

        $repeater->add_control(
            'content_title_color',
            [
                'label'     => __('Title Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body {{CURRENT_ITEM}} ' . $widget_selector . '__custom-container-cont-inner > ' . $widget_selector . '__custom-widget-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'offcanvas_item_style' => 'yes',
                    'title!'               => '',
                ],
            ]
        );

        $repeater->add_control(
            'content_text_color',
            [
                'label'     => __('Text Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body {{CURRENT_ITEM}} ' . $widget_selector . '__custom-container-cont-inner ' . $widget_selector . '__menu-container,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body {{CURRENT_ITEM}} ' . $widget_selector . '__custom-container-cont-inner ' . $widget_selector . '__menu-container a,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body {{CURRENT_ITEM}} ' . $widget_selector . '__custom-container-cont-inner > div,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body {{CURRENT_ITEM}} ' . $widget_selector . '__custom-container-cont-inner .widget *' => 'color: {{VALUE}}',
                ],
                'condition' => ['offcanvas_item_style' => 'yes'],
            ]
        );

        $repeater->add_control(
            'content_custom_bg',
            [
                'label'       => __('Background Color', 'master-addons' ),
                'type'        => Controls_Manager::COLOR,
                'render_type' => 'template',
                'selectors'   => [
                    '.jltma-offcanvas-content-{{ID}} {{CURRENT_ITEM}} ' . $widget_selector . '__custom-container-cont-inner' => 'background-color: {{VALUE}}',
                ],
                'condition' => ['offcanvas_item_style' => 'yes'],
            ]
        );

        $repeater->end_popover();

        $repeater->add_control(
            'box_to_down',
            [
                'label'        => __('Stick to bottom', 'master-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'render_type'  => 'template',
                'default'      => 'false',
            ]
        );

        $this->add_control(
            'content_block',
            [
                'label'   => __('Canvas Items', 'master-addons' ),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    ['content_type' => 'logo'],
                ],
                'show_label'         => false,
                'title_field'        => '<# if ( \'logo\' === content_type ) { #>Site Logo<# } else if ( \'custom\' === content_type ) { #>Content<# } else if ( \'navigation\' === content_type ) { #>Navigation<# } else if ( \'sidebar\' === content_type ) { #>Sidebar<# } else if ( \'section\' === content_type ) { #>Section<# } else if ( \'template\' === content_type ) { #>Page<# } if ( \'\' !== title ) { #> - {{{ title }}}<# } if ( \'true\' === box_to_down ) { #><i class="fas fa-long-arrow-alt-down" style="margin: 0 0 0 10px"></i><# } #>',
                'render_type'        => 'template',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'canvas_position',
            [
                'label'   => __('Position', 'master-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'master-addons' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'master-addons' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'            => 'left',
                'toggle'             => false,
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'canvas_width',
            [
                'label'      => __('Width', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'vh'],
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'tablet_default' => [
                    'unit' => '%',
                    'size' => 35,
                ],
                'mobile_default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}}'                                                                                               => 'width: {{SIZE}}{{UNIT}}',
                    '.jltma-offcanvas-content-{{ID}}.jltma-canvas-position-left'                                                                    => 'left: -{{SIZE}}{{UNIT}}',
                    '.jltma-offcanvas-content-{{ID}}.jltma-canvas-position-right'                                                                   => 'right: -{{SIZE}}{{UNIT}}',
                    ".jltma-offcanvas-content-open-{{ID}}.jltma-offcanvas-content-push.jltma-offcanvas-content-left {$widget_selector}__container"  => 'left: {{SIZE}}{{UNIT}}',
                    ".jltma-offcanvas-content-open-{{ID}}.jltma-offcanvas-content-push.jltma-offcanvas-content-right {$widget_selector}__container" => 'left: -{{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'animation_type',
            [
                'label'   => __('Animation Type', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'slide' => [
                        'title' => __('Slide', 'master-addons' )
                    ],
                    'push'  => [
                        'title' => __('Push', 'master-addons' )
                    ],
                ],
                'default'            => 'slide',
                'label_block'        => false,
                'render_type'        => 'template',
                'frontend_available' => true,
                'toggle'             => false,
                'separator'          => 'before',
            ]
        );

        $this->end_controls_section();
    }


    /*
    * Trigger
    */
    protected function jltma_offcanvas_trigger_section()
    {
        $widget_selector = $this->get_widget_selector();

        $this->start_controls_section(
            'section_trigger',
            ['label' => __('Trigger', 'master-addons' )]
        );


        $this->add_control(
            'trigger_alignment',
            [
                'label'                => __('Alignment', 'master-addons' ),
                'type'                 => Controls_Manager::CHOOSE,
                'options'              => Master_Addons_Helper::jltma_content_alignments(),
                'default'              => 'center',
                'toggle'               => false,
                'label_block'          => false,
                'selectors_dictionary' => [
                    'left'    => 'flex-start;',
                    'center'  => 'center;',
                    'right'   => 'flex-end;',
                    'stretch' => 'stretch',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger-container' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'trigger_type',
            [
                'label'   => __('Type', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'icon' => [
                        'title'       => __('Icon', 'master-addons' ),
                        'description' => 'Trigger has only icon',
                    ],
                    'text' => [
                        'title'       => __('Text', 'master-addons' ),
                        'description' => 'Trigger has only text',
                    ],
                    'both' => [
                        'title'       => __('Both', 'master-addons' ),
                        'description' => 'Trigger has icon and text',
                    ],
                ],
                'default'     => 'icon',
                'label_block' => false,
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'trigger_view',
            [
                'label'   => __('View', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'default' => ['title' => __('Default', 'master-addons' )],
                    'stacked' => ['title' => __('Stacked', 'master-addons' )],
                    'framed'  => ['title' => __('Framed', 'master-addons' )],
                ],
                'default'      => 'default',
                'label_block'  => false,
                'prefix_class' => 'jltma-trigger-view-',
            ]
        );

        $this->add_control(
            'trigger_shape',
            [
                'label'   => __('Shape', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'square' => ['title' => __('Square', 'master-addons' )],
                    'circle' => ['title' => __('Circle', 'master-addons' )],
                ],
                'default'      => 'square',
                'label_block'  => false,
                'prefix_class' => 'jltma-trigger-shape-',
                'condition'    => [
                    'trigger_view!'      => 'default',
                    'trigger_type'       => 'icon',
                    'trigger_alignment!' => 'stretch',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_trigger_icon',
            [
                'condition' => ['trigger_type!' => 'text']
            ]
        );

        $this->start_controls_tab(
            'tab_trigger_icon_normal',
            [
                'label' => __('Normal', 'master-addons' )
            ]
        );

        $this->add_control(
            'trigger_icon',
            [
                'label'            => __('Icon', 'master-addons' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'recommended'      => [
                    'fa-solid' => [
                        'align-justify',
                        'hamburger',
                        'list',
                    ],
                ],
                'default'          => [
                    'value'   => 'fas fa-bars',
                    'library' => 'solid',
                ],
                'file'       => '',
                'show_label' => false,
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_trigger_icon_active',
            [
                'label' => __('Active', 'master-addons' )
            ]
        );

        $this->add_control(
            'trigger_icon_active',
            [
                'label'            => __('Icon', 'master-addons' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'recommended'      => [
                    'fa-solid' => [
                        'times',
                        'times-circle',
                    ],
                    'fa-regular' => [
                        'times-circle',
                    ],
                ],
                'file'       => '',
                'show_label' => false,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'trigger_text',
            [
                'label'       => __('Text', 'master-addons' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('More', 'master-addons' ),
                'separator'   => 'before',
                'condition'   => ['trigger_type!' => 'icon'],
            ]
        );

        $this->add_responsive_control(
            'trigger_text_icon_position',
            [
                'label'       => __('Position', 'master-addons' ),
                'type'        => 'jltma-choose-text',
                'description' => __('Will be applied only if Justified Alignment is chosen.', 'master-addons' ),
                'options'     => [
                    'central' => [
                        'title' => __('Central', 'master-addons' ),
                    ],
                    'on-sides' => [
                        'title' => __('On Sides', 'master-addons' ),
                    ],
                ],
                'default'      => 'central',
                'label_block'  => false,
                'prefix_class' => 'jltma-trigger-text-icon%s-position-',
                'condition'    => ['trigger_type' => 'both'],
            ]
        );

        $this->add_responsive_control(
            'trigger_icon_gap',
            [
                'label' => __('Horizontal Gap', 'master-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger-icon-active + ' . $widget_selector . '__trigger-label' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['trigger_type' => 'both'],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Offcanvas Close section
     *
     * @return void
     */
    protected function jltma_offcanvas_close_section()
    {
        $widget_selector = $this->get_widget_selector();

        $this->start_controls_section(
            'section_close',
            [
                'label' => __('Close', 'master-addons' )
            ]
        );

        $this->add_control(
            'close_button_position',
            [
                'label'   => __('Position', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'inside' => [
                        'title'       => __('Inside', 'master-addons' ),
                        'description' => __('Button will be inside box', 'master-addons' ),
                    ],
                    'outside' => [
                        'title'       => __('Outside', 'master-addons' ),
                        'description' => __('Button will be outside box', 'master-addons' ),
                    ],
                ],
                'default'     => 'inside',
                'label_block' => false,
            ]
        );

        $this->add_control(
            'close_button_horizontal_alignment',
            [
                'label'   => __('Alignment', 'master-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'master-addons' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'master-addons' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'master-addons' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'stretch' => [
                        'title' => __('Justified', 'master-addons' ),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'default'   => 'right',
                'condition' => ['close_button_position' => 'inside'],
            ]
        );

        $this->add_control(
            'close_button_vertical_alignment',
            [
                'label'   => __('Vertical Alignment', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'top'    => ['title' => __('Top', 'master-addons' )],
                    'middle' => ['title' => __('Middle', 'master-addons' )],
                ],
                'default'     => 'top',
                'label_block' => false,
                'condition'   => ['close_button_position' => 'outside'],
            ]
        );

        $this->add_responsive_control(
            'close_button_ver_gap',
            [
                'label'      => __('Gap', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close-container' => 'top: {{SIZE}}{{UNIT}} !important',
                ],
                'condition' => [
                    'close_button_position'           => 'outside',
                    'close_button_vertical_alignment' => 'top',
                ],
            ]
        );

        $this->add_control(
            'close_button_type',
            [
                'label'   => __('Type', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'icon' => [
                        'title'       => __('Icon', 'master-addons' ),
                        'description' => 'Close button has only icon',
                    ],
                    'text' => [
                        'title'       => __('Text', 'master-addons' ),
                        'description' => 'Close button has only text',
                    ],
                    'both' => [
                        'title'       => __('Both', 'master-addons' ),
                        'description' => 'Close button has icon and text',
                    ],
                ],
                'default'     => 'icon',
                'label_block' => false,
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'close_button_view',
            [
                'label'   => __('View', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'default' => ['title' => __('Default', 'master-addons' )],
                    'stacked' => ['title' => __('Stacked', 'master-addons' )],
                    'framed'  => ['title' => __('Framed', 'master-addons' )],
                ],
                'default'     => 'default',
                'label_block' => false,
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'close_button_shape',
            [
                'label'   => __('Shape', 'master-addons' ),
                'type'    => 'jltma-choose-text',
                'options' => [
                    'square' => ['title' => __('Square', 'master-addons' )],
                    'circle' => ['title' => __('Circle', 'master-addons' )],
                ],
                'default'     => 'square',
                'label_block' => false,
                'render_type' => 'template',
                'condition'   => [
                    'close_button_type'                  => 'icon',
                    'close_button_horizontal_alignment!' => 'stretch',
                    'close_button_view!'                 => 'default',
                ],
            ]
        );

        $this->add_control(
            'close_button_cont_hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_control(
            'close_button_icon',
            [
                'label'            => __('Icon', 'master-addons' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'recommended'      => [
                    'fa-solid' => [
                        'times',
                        'times-circle',
                    ],
                    'fa-regular' => [
                        'times-circle',
                    ],
                ],
                'file'      => '',
                'condition' => ['close_button_type!' => 'text'],
            ]
        );

        $this->add_control(
            'close_button_text',
            [
                'label'       => __('Text', 'master-addons' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Close', 'master-addons' ),
                'condition'   => ['close_button_type!' => 'icon'],
            ]
        );

        $this->add_control(
            'overlay_close',
            [
                'label'              => __('Close With Click on Overlay', 'master-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'description'        => __('Close popup upon click/tap on overlay', 'master-addons' ),
                'default'            => 'yes',
                'frontend_available' => true,
                'separator'          => 'before',
            ]
        );

        $this->add_control(
            'esc_close',
            [
                'label'              => __('Close by ESC Button Click', 'master-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
                'return_value'       => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();
    }


    /**
     * Offcanvas Style
     *
     * @return void
     */
    protected function jltma_offcanvas_canvas_style()
    {
        $widget_selector = $this->get_widget_selector();

        $this->start_controls_section(
            'section_style_canvas',
            [
                'label' => __('Canvas', 'master-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_align',
            [
                'label'   => __('Alignment', 'master-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'master-addons' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'master-addons' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'master-addons' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__custom-container-cont-inner' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'box_bg',
                'label'    => __('Background Color', 'master-addons' ),
                'default'  => 'classic',
                'selector' => '.jltma-offcanvas-content-{{ID}}',
            ]
        );

        $this->add_responsive_control(
            'box_margin_bottom',
            [
                'label'      => __('Gap Between', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors'  => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__custom-container-cont' => 'margin-top: calc( {{SIZE}}{{UNIT}} / 2 ); padding-top: calc( {{SIZE}}{{UNIT}} / 2 );',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label'      => __('Padding', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'separator'  => 'before',
                'selectors'  => [
                    '.jltma-offcanvas-content-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => __('Border', 'master-addons' ),
                'fields_options' => [
                    'width' => [
                        'label' => _x('Border Width', 'Border Control', 'master-addons' ),
                        'selectors' => [
                            '.jltma-offcanvas-content-{{ID}}' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close-container.jltma-position-outside' => 'padding-left: {{LEFT}}{{UNIT}}; margin-top: -{{TOP}}{{UNIT}};',
                        ],
                    ],
                    'color' => [
                        'label' => _x('Border Color', 'Border Control', 'master-addons' ),
                    ],
                ],
                'selector' => '.jltma-offcanvas-content-{{ID}}',
            ]
        );

        $this->add_control(
            'overlay_bg_overlay',
            [
                'label' => __('Background Overlay', 'master-addons' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    $widget_selector . '__container ' . $widget_selector . '__container__overlay' => '--overlay-bg-overlay: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Offcanvas Item Style
     *
     * @return void
     */
    protected function jltma_offcanvas_item_style()
    {
        $widget_selector = $this->get_widget_selector();

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => __('Item', 'master-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_title_heading',
            [
                'label'     => __('Title', 'master-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_title_alignment',
            [
                'label'   => __('Alignment', 'master-addons' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => Master_Addons_Helper::jltma_content_alignment(),
                'label_block' => false,
                'selectors'   => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > ' . $widget_selector . '__custom-widget-title,
                    .jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget > .widget-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'item_title_typography',
                'label'    => __('Typography', 'master-addons' ),
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > ' . $widget_selector . '__custom-widget-title, .jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget > .widget-title',
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label'     => __('Title Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > ' . $widget_selector . '__custom-widget-title,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget > .widget-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_bg',
            [
                'label'     => __('Background Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > ' . $widget_selector . '__custom-widget-title,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget > .widget-title' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_title_gap',
            [
                'label'      => __('Gap Between', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > ' . $widget_selector . '__custom-widget-title,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget > .widget-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['trigger_type!' => 'text'],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'item_title_border',
                'label'          => __('Border', 'master-addons' ),
                'fields_options' => [
                    'width' => [
                        'label' => _x('Border Width', 'Border Control', 'master-addons' ),
                    ],
                    'color' => [
                        'label' => _x('Border Color', 'Border Control', 'master-addons' ),
                    ],
                ],
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > ' . $widget_selector . '__custom-widget-title, .jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget > .widget-title',
            ]
        );

        $this->add_control(
            'item_title_radius',
            [
                'label'      => __('Border Radius', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > ' . $widget_selector . '__custom-widget-title,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget > .widget-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_title_padding',
            [
                'label'      => __('Padding', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > ' . $widget_selector . '__custom-widget-title,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget > .widget-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_text_heading',
            [
                'label'     => __('Text', 'master-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'item_text_typography',
                'label'    => __('Typography', 'master-addons' ),
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > *:not(' . $widget_selector . '__site-logo):not(' . $widget_selector . '__menu-container):not(' . $widget_selector . '__custom-widget-title),.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget *',
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label'     => __('Text Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > *:not(' . $widget_selector . '__site-logo):not(' . $widget_selector . '__menu-container):not(' . $widget_selector . '__custom-widget-title),.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget *' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_link_heading',
            [
                'label'     => __('Link', 'master-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_links_typography',
                'label' => __('Typography', 'master-addons' ),
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > *:not(' . $widget_selector . '__site-logo):not(' . $widget_selector . '__menu-container) a,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget * a',
            ]
        );

        $this->start_controls_tabs('tabs_item_links_style');

        $this->start_controls_tab(
            'tab_item_links_normal',
            ['label' => __('Normal', 'master-addons' )]
        );

        $this->add_control(
            'item_links_color',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > *:not(' . $widget_selector . '__site-logo):not(' . $widget_selector . '__menu-container) a' => 'color: {{VALUE}}',
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget * a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_links_hover',
            [
                'label' => __('Hover', 'master-addons' )
            ]
        );

        $this->add_control(
            'item_links_color_hover',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__custom-container-cont-inner > *:not(' . $widget_selector . '__site-logo):not(' . $widget_selector . '__menu-container) a:hover,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body .widget * a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'item_divider_heading',
            [
                'label'     => __('Divider', 'master-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_divider_type',
            [
                'label'   => __('Divider Type', 'master-addons' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'none'   => __('None', 'master-addons' ),
                    'solid'  => __('Solid', 'master-addons' ),
                    'double' => __('Double', 'master-addons' ),
                    'dotted'  => __('Doted', 'master-addons' ),
                    'dashed' => __('Dashed', 'master-addons' ),
                    'groove' => __('Groove', 'master-addons' ),
                ],
                'default'   => 'none',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__custom-container-cont' => 'border-top-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_divider_size',
            [
                'label' => __('Divider Size', 'master-addons' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['max' => 15],
                ],
                'default'   => ['size' => 1],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__custom-container-cont' => 'border-top-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['item_divider_type!' => 'none'],
            ]
        );

        $this->add_control(
            'item_divider_color',
            [
                'label'     => __('Divider Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__custom-container-cont' => 'border-top-color: {{VALUE}};',
                ],
                'condition' => ['item_divider_type!' => 'none'],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Offcanvas Trigger Style
     *
     * @return void
     */
    protected function jltma_offcanvas_trigger_style()
    {
        $widget_selector = $this->get_widget_selector();

        $this->start_controls_section(
            'section_style_trigger',
            [
                'label' => __('Trigger', 'master-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'offcanvas_trigger_typography',
                'fields_options' => [
                    'text_decoration' => [
                        'selectors' => [
                            '{{WRAPPER}}' => '--trigger-text-decoration: {{VALUE}};',
                        ],
                    ],
                ],
                'selector'  => '{{WRAPPER}} ' . $widget_selector . '__trigger',
                'condition' => ['trigger_type!' => 'icon'],
            ]
        );

        $this->start_controls_tabs('tabs_trigger_style');

        $this->start_controls_tab(
            'tab_trigger_style_normal',
            ['label' => __('Normal', 'master-addons' )]
        );

        $this->add_control(
            'trigger_primary',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#777',
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger' => 'color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            'jltma-button-background',
            [
                'name'      => 'trigger_bg',
                'exclude'   => ['color'],
                'selector'  => '{{WRAPPER}} ' . $widget_selector . '__trigger',
                'condition' => ['trigger_view!' => 'default'],
            ]
        );

        $this->start_injection(['of' => 'trigger_bg_background']);

        $this->add_control(
            'trigger_secondary',
            [
                'label'     => __('Background Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger' => '--button-bg-color: {{VALUE}}; ' .
                        'background: var( --button-bg-color );',
                ],
                'condition' => [
                    'trigger_bg_background' => [
                        'color',
                        'gradient',
                    ],
                    'trigger_view!' => 'default',
                ],
            ]
        );

        $this->end_injection();

        $this->add_control(
            'trigger_bd_color',
            [
                'label'     => __('Border Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'trigger_view'                 => 'framed',
                    'trigger_framed_border_style!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'trigger_border_radius',
            [
                'label'      => __('Border Radius', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [
                    'px',
                    '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['trigger_view!' => 'default'],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'trigger_text_shadow',
                'selector' => '{{WRAPPER}} .jltma-offcanvas-menu__trigger, {{WRAPPER}} .jltma-offcanvas-menu__trigger .jltma-offcanvas-menu__trigger-label',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trigger_box_shadow',
                'selector' => '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger,
					{{WRAPPER}}.jltma-trigger-view-stacked ' . $widget_selector . '__trigger',
                'condition' => ['trigger_view!' => 'default'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_trigger_style_hover',
            ['label' => __('Hover', 'master-addons' )]
        );

        $this->add_control(
            'trigger_primary_hover',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            'jltma-button-background',
            [
                'name'      => 'trigger_bg_hover',
                'exclude'   => ['color'],
                'selector'  => '{{WRAPPER}} ' . $widget_selector . '__trigger:hover',
                'condition' => ['trigger_view!' => 'default'],
            ]
        );

        $this->start_injection(['of' => 'trigger_bg_hover_background']);

        $this->add_control(
            'trigger_secondary_hover',
            [
                'label'     => __('Background Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger:hover' => '--button-bg-color: {{VALUE}}; ' .
                        'background: var( --button-bg-color );',
                ],
                'condition' => [
                    'trigger_bg_hover_background' => [
                        'color',
                        'gradient',
                    ],
                    'trigger_view!' => 'default',
                ],
            ]
        );

        $this->end_injection();

        $this->add_control(
            'trigger_bd_color_hover',
            [
                'label'     => __('Border Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'trigger_view'                 => 'framed',
                    'trigger_framed_border_style!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'trigger_border_radius_hover',
            [
                'label'      => __('Border Radius', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [
                    'px',
                    '%',
                ],
                'selectors' => [
                    '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger:hover,
					{{WRAPPER}}.jltma-trigger-view-stacked ' . $widget_selector . '__trigger:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['trigger_view!' => 'default'],
            ]
        );

        $this->add_control(
            'trigger_text_decoration_hover',
            [
                'label'   => __('Text Decoration', 'master-addons' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''             => __('Default', 'master-addons' ),
                    'none'         => _x('None', 'Typography Control', 'master-addons' ),
                    'underline'    => _x('Underline', 'Typography Control', 'master-addons' ),
                    'overline'     => _x('Overline', 'Typography Control', 'master-addons' ),
                    'line-through' => _x('Line Through', 'Typography Control', 'master-addons' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger:hover' => 'text-decoration: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'trigger_text_shadow_hover',
                'selector' => '{{WRAPPER}} .jltma-offcanvas-menu__trigger:hover,{{WRAPPER}} .jltma-offcanvas-menu__trigger:hover .jltma-offcanvas-menu__trigger-label',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trigger_box_shadow_hover',
                'selector' => '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger:hover,
					{{WRAPPER}}.jltma-trigger-view-stacked ' . $widget_selector . '__trigger:hover',
                'condition' => ['trigger_view!' => 'default'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_trigger_style_active',
            ['label' => __('Active', 'master-addons' )]
        );

        $this->add_control(
            'trigger_primary_active',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '. $widget_selector . '__trigger.trigger-active' => 'color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger.trigger-active' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            'jltma-button-background',
            [
                'name'      => 'trigger_bg_active',
                'exclude'   => ['color'],
                'selector'  => '{{WRAPPER}} ' . $widget_selector . '__trigger.trigger-active',
                'condition' => ['trigger_view!' => 'default'],
            ]
        );

        $this->start_injection(['of' => 'trigger_bg_active_background']);

        $this->add_control(
            'trigger_secondary_active',
            [
                'label'     => __('Background Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger.trigger-active' => '--button-bg-color: {{VALUE}}; ' .
                        'background: var( --button-bg-color );',
                ],
                'condition' => [
                    'trigger_bg_active_background' => [
                        'color',
                        'gradient',
                    ],
                    'trigger_view!' => 'default',
                ],
            ]
        );

        $this->end_injection();

        $this->add_control(
            'trigger_bd_color_active',
            [
                'label'     => __('Border Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger.trigger-active' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'trigger_view'                 => 'framed',
                    'trigger_framed_border_style!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'trigger_border_radius_active',
            [
                'label'      => __('Border Radius', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [
                    'px',
                    '%',
                ],
                'selectors' => [
                    '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger.trigger-active,
					{{WRAPPER}}.jltma-trigger-view-stacked ' . $widget_selector . '__trigger.trigger-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['trigger_view!' => 'default'],
            ]
        );

        $this->add_control(
            'trigger_text_decoration_active',
            [
                'label'   => __('Text Decoration', 'master-addons' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''             => __('Default', 'master-addons' ),
                    'none'         => _x('None', 'Typography Control', 'master-addons' ),
                    'underline'    => _x('Underline', 'Typography Control', 'master-addons' ),
                    'overline'     => _x('Overline', 'Typography Control', 'master-addons' ),
                    'line-through' => _x('Line Through', 'Typography Control', 'master-addons' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} '. $widget_selector . '__trigger.trigger-active' => 'text-decoration: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'trigger_text_shadow_active',
                'selector' => '{{WRAPPER}} .jltma-offcanvas-menu__trigger.trigger-active,{{WRAPPER}} .jltma-offcanvas-menu__trigger.trigger-active .jltma-offcanvas-menu__trigger-label',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'trigger_box_shadow_active',
                'selector' => '{{WRAPPER}}.jltma-trigger-view-framed ' . $widget_selector . '__trigger.trigger-active,
					{{WRAPPER}}.jltma-trigger-view-stacked ' . $widget_selector . '__trigger.trigger-active',
                'condition' => ['trigger_view!' => 'default'],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'trigger_hr',
            [
                'type'  => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_responsive_control(
            'trigger_icon_size',
            [
                'label'      => __('Icon Size', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [
                    'px',
                    'em',
                    '%',
                    'vw',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $widget_selector . '__trigger svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['trigger_type!' => 'text'],
            ]
        );

        $this->add_responsive_control(
            'trigger_padding',
            [
                'label'      => __('Padding', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'trigger_view!' => 'default',
                    'trigger_shape' => 'square',
                ],
            ]
        );

        $this->add_responsive_control(
            'trigger_icon_padding',
            [
                'label'      => __('Padding', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [
                    'px',
                    'em',
                    '%',
                    'vw',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'trigger_type'   => 'icon',
                    'trigger_view!'  => 'default',
                    'trigger_align!' => 'stretch',
                    'trigger_shape'  => 'circle',
                ],
            ]
        );

        $this->add_control(
            'trigger_framed_border_style',
            [
                'label'   => _x('Border Type', 'Border Control', 'master-addons' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'default' => __('Default', 'master-addons' ),
                    'solid'   => _x('Solid', 'Border Control', 'master-addons' ),
                    'double'  => _x('Double', 'Border Control', 'master-addons' ),
                    'dotted'  => _x('Dotted', 'Border Control', 'master-addons' ),
                    'dashed'  => _x('Dashed', 'Border Control', 'master-addons' ),
                    'groove'  => _x('Groove', 'Border Control', 'master-addons' ),
                ],
                'default'      => 'default',
                'prefix_class' => 'jltma-trigger-border-type-',
                'selectors'    => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger' => 'border-style: {{VALUE}};',
                ],
                'condition' => ['trigger_view' => 'framed'],
            ]
        );

        $this->add_responsive_control(
            'trigger_framed_border_width',
            [
                'label'      => __('Border Width', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $widget_selector . '__trigger' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'trigger_view'                 => 'framed',
                    'trigger_framed_border_style!' => [
                        '',
                        'default',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Offcanvas Close Style
     *
     * @return void
     */
    protected function jltma_offcanvas_close_style()
    {
        $widget_selector = $this->get_widget_selector();

        $this->start_controls_section(
            'section_style_close',
            [
                'label' => __('Close', 'master-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'close_bottom_gap',
            [
                'label'      => __('Bottom Gap', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [
                    'px',
                    '%',
                    'vh',
                    'vw',
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close-container.jltma-position-inside' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['close_button_position' => 'inside'],
            ]
        );

        $this->start_controls_tabs('tabs_popup_close_style');

        $this->start_controls_tab(
            'tab_close_normal',
            ['label' => __('Normal', 'master-addons' )]
        );

        $this->add_control(
            'close_primary',
            [
                'label'     => __('Primary Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close'     => 'color: {{VALUE}}',
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close svg' => 'fill: {{VALUE}}',
                    '.jltma-offcanvas-content-{{ID}} .jltma-close-view-framed ' . $widget_selector . '__close'     => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'close_secondary',
            [
                'label'     => __('Secondary Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close' => 'background-color: {{VALUE}}',
                ],
                'condition' => ['close_button_view!' => 'default'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_close_hover',
            ['label' => __('Hover', 'master-addons' )]
        );

        $this->add_control(
            'close_primary_hover',
            [
                'label'     => __('Primary Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close:hover'     => 'color: {{VALUE}}',
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close:hover svg' => 'fill: {{VALUE}}',
                    '.jltma-offcanvas-content-{{ID}} .jltma-close-view-framed ' . $widget_selector . '__close:hover'     => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'close_secondary_hover',
            [
                'label'     => __('Secondary Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close:hover' => 'background-color: {{VALUE}}',
                ],
                'condition' => ['close_button_view!' => 'default'],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'close_button_hr',
            [
                'type'  => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'close_typography',
                'selector'  => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close-label',
                'condition' => ['close_button_type!' => 'icon'],
            ]
        );

        $this->add_responsive_control(
            'close_icon_size',
            [
                'label'      => __('Icon Size', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close svg'  => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['close_button_type!' => 'text'],
            ]
        );

        $this->add_responsive_control(
            'close_icon_gap',
            [
                'label'      => __('Icon Gap', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors'  => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close ' . $widget_selector . '__close-icon + span' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['close_button_type' => 'both'],
            ]
        );

        $this->add_responsive_control(
            'close_padding',
            [
                'label'      => __('Padding', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'close_button_view!'  => 'default',
                    'close_button_shape!' => 'circle',
                ],
            ]
        );

        $this->add_responsive_control(
            'close_icon_padding',
            [
                'label' => __('Padding', 'master-addons' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close' => 'padding: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'close_button_type'  => 'icon',
                    'close_button_view!' => 'default',
                    'popup_close_shape'  => 'circle',
                ],
            ]
        );

        $this->add_control(
            'close_framed_border_width',
            [
                'label'      => __('Border Width', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['close_button_view' => 'framed'],
            ]
        );

        $this->add_control(
            'close_border_radius',
            [
                'label'      => __('Border Radius', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [
                    'px',
                    '%',
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['close_button_view!' => 'default'],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'close_box_shadow',
                'selector'  => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__close',
                'condition' => ['close_button_view!' => 'default'],
            ]
        );

        $this->end_controls_section();
    }


    /**
     * Offcanvas Site Logo Style
     *
     * @return void
     */
    protected function jltma_offcanvas_site_logo_style()
    {
        $widget_selector = $this->get_widget_selector();

        $this->start_controls_section(
            'section_style_site_logo',
            [
                'label' => __('Site Logo', 'master-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'site_logo_image_heading',
            [
                'label' => __('Image', 'master-addons' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'site_logo_image_width',
            [
                'label'      => __('Width', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                ],
                'size_units' => [
                    '%',
                    'px',
                ],
                'range' => [
                    '%' => [
                        'min' => 15,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'site_logo_image_max_width',
            [
                'label'      => __('Max Width', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 150,
                ],
                'size_units' => [
                    '%',
                    'px',
                ],
                'range' => [
                    '%' => [
                        'min' => 15,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('site_logo_image_effects_tabs');

        $this->start_controls_tab(
            'site_logo_image_normal_tab',
            ['label' => __('Normal', 'master-addons' )]
        );

        $this->add_control(
            'site_logo_image_bg_color',
            [
                'label'     => __('Background Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'site_logo_image_bd_color',
            [
                'label'     => __('Border Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img' => 'border-color: {{VALUE}};',
                ],
                'condition' => ['site_logo_image_border_border!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'site_logo_image_box_shadow',
                'exclude'  => ['box_shadow_position'],
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img',
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'site_logo_image_css_filters',
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'site_logo_image_hover_tab',
            ['label' => __('Hover', 'master-addons' )]
        );

        $this->add_control(
            'site_logo_image_bg_color_hover',
            [
                'label'     => __('Background Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'site_logo_image_bd_color_hover',
            [
                'label'     => __('Border Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => ['site_logo_image_border_border!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'site_logo_image_box_shadow_hover',
                'exclude'  => ['box_shadow_position'],
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'site_logo_image_css_filters_hover',
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img:hover',
            ]
        );

        $this->add_control(
            'site_logo_image_bg_hover_transition',
            [
                'label' => __('Transition Duration', 'master-addons' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'site_logo_image_padding',
            [
                'label'      => __('Padding', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'separator'  => 'before',
                'selectors'  => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'site_logo_image_border',
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img',
                'exclude'  => ['color'],
            ]
        );

        $this->add_responsive_control(
            'site_logo_image_border_radius',
            [
                'label'      => __('Border Radius', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [
                    'px',
                    '%',
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'site_logo_title_heading',
            [
                'label'     => __('Logo Title', 'master-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'site_logo_title_typography',
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title > a',
            ]
        );

        $this->start_controls_tabs('site_logo_title_tabs');

        $this->start_controls_tab(
            'site_logo_title_normal_tab',
            ['label' => __('Normal', 'master-addons' )]
        );

        $this->add_control(
            'site_logo_title_color',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'           => 'site_logo_title_shadow',
                'fields_options' => [
                    'text_shadow_type' => ['label' => __('Text Shadow', 'master-addons' )],
                ],
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title > a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'site_logo_title_hover_tab',
            ['label' => __('Hover', 'master-addons' )]
        );

        $this->add_control(
            'site_logo_title_color_hover',
            [
                'label'     => __('Hover Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title:hover,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title:hover > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'site_logo_title_shadow_hover',
                'fields_options' => [
                    'text_shadow_type' => ['label' => __('Text Shadow', 'master-addons' )],
                ],
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title:hover,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title:hover > a',
            ]
        );

        $this->add_control(
            'site_logo_title_hover_transition',
            [
                'label' => __('Transition Duration', 'master-addons' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__site-logo-title' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }


    /**
     * Offcanvas Menu Style
     *
     * @return void
     */
    protected function jltma_offcanvas_menu_style()
    {
        $widget_selector = $this->get_widget_selector();

        $this->start_controls_section(
            'section_style_menu',
            [
                'label' => __('Menu', 'master-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_main_heading',
            [
                'label' => __('Main', 'master-addons' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'menu_main_typography',
                'label'    => __('Typography', 'master-addons' ),
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner > li > a',
            ]
        );

        $this->start_controls_tabs('tabs_menu_main');

        $this->start_controls_tab(
            'tab_menu_main_normal',
            ['label' => __('Normal', 'master-addons' )]
        );

        $this->add_control(
            'menu_main_color',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner > li > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_main_hover',
            ['label' => __('Hover', 'master-addons' )]
        );

        $this->add_control(
            'menu_main_color_hover',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-container ' . $widget_selector . '__menu-inner > li > a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_main_active',
            ['label' => __('Active', 'master-addons' )]
        );

        $this->add_control(
            'menu_main_color_active',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner > li.current-menu-item > a,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner > li.current-menu-item > a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'menu_main_gap',
            [
                'label'      => __('Gap Between', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner > li' => 'padding-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'menu_dropdown_heading',
            [
                'label'     => __('Dropdown', 'master-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'menu_dropdown_typography',
                'label'    => __('Typography', 'master-addons' ),
                'selector' => '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner ul > li > a',
            ]
        );

        $this->start_controls_tabs('tabs_menu_dropdown');

        $this->start_controls_tab(
            'tab_menu_dropdown_normal',
            ['label' => __('Normal', 'master-addons' )]
        );

        $this->add_control(
            'menu_dropdown_color',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner ul > li > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_dropdown_hover',
            ['label' => __('Hover', 'master-addons' )]
        );

        $this->add_control(
            'menu_dropdown_color_hover',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-container ' . $widget_selector . '__menu-inner ul > li > a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_dropdown_active',
            ['label' => __('Active', 'master-addons' )]
        );

        $this->add_control(
            'menu_dropdown_color_active',
            [
                'label'     => __('Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner ul > li.current-menu-item > a,
					.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner ul > li.current-menu-item > a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'menu_dropdown_offset',
            [
                'label'      => __('Side Gap', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner ul' => 'padding-left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_dropdown_gap',
            [
                'label'      => __('Item Gap Between', 'master-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '.jltma-offcanvas-content-{{ID}} ' . $widget_selector . '__body ' . $widget_selector . '__menu-inner ul > li' => 'padding-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_controls()
    {
        $this->jltma_offcanvas_general_section();
        $this->jltma_offcanvas_trigger_section();
        $this->jltma_offcanvas_close_section();

        // Offcanvas Style
        $this->jltma_offcanvas_canvas_style();
        $this->jltma_offcanvas_item_style();
        $this->jltma_offcanvas_trigger_style();
        $this->jltma_offcanvas_close_style();
        $this->jltma_offcanvas_site_logo_style();
        $this->jltma_offcanvas_menu_style();
    }


    /**
     * @return string sidebar content
     */
    public function get_dynamic_sidebar($name)
    {
        $contents = '';

        ob_start();

        dynamic_sidebar($name);

        $contents = ob_get_clean();

        return $contents;
    }

    /**
     * @return array menus list
     */
    public function get_available_menus()
    {
        $menus = wp_list_pluck(
            wp_get_nav_menus(),
            'name',
            'term_id'
        );

        return $menus;
    }


    /**
     * Return trigger for offcanvas output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    public function get_trigger()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('jltma_offcanvas_trigger_btn', 'class', 'jltma-offcanvas-menu__trigger');

        $trigger_type = $settings['trigger_type'];

        if ('both' === $trigger_type) {
            $this->add_render_attribute('jltma_offcanvas_trigger_btn', 'class', 'jltma-trigger-both');
        }

        echo '<div class="jltma-offcanvas-menu__trigger-container">' .
            '<div ' . $this->get_render_attribute_string('jltma_offcanvas_trigger_btn') . '>';

        if ('text' !== $trigger_type) {
            $trigger_icon = $settings['trigger_icon'];

            echo '<span class="jltma-offcanvas-menu__trigger-icon">';

            if ('' !== $trigger_icon['value']) {
                Icons_Manager::render_icon($trigger_icon);
            } else {
                echo '<i class="eicon-menu-bar"></i>';
            }

            echo '</span>';

            $trigger_icon_active = $settings['trigger_icon_active'];

            echo '<span class="jltma-offcanvas-menu__trigger-icon-active">';

            if ('' !== $trigger_icon_active['value']) {
                Icons_Manager::render_icon($trigger_icon_active);
            } else {
                echo '<i class="eicon-close"></i>';
            }

            echo '</span>';
        }

        if ('icon' !== $trigger_type) {
            echo '<span class="jltma-offcanvas-menu__trigger-label">';

            $trigger_text = $settings['trigger_text'];

            if ('' !== $trigger_text) {
                echo esc_html($trigger_text);
            } else {
                echo esc_html__('More', 'master-addons' );
            }

            echo '</span>';
        }

        echo '</div>' .
            '</div>';
    }


    /**
     * Return content in offcanvas output on the frontend.
     * Written in PHP and used to generate the final HTML.
     * Added output site logo for content type `Site Logo`.
     */
    public function get_content()
    {
        $settings = $this->get_settings_for_display();

        $animation_type = !empty($settings['animation_type']) ? $settings['animation_type'] : 'slide';
        $canvas_position = !empty($settings['canvas_position']) ? $settings['canvas_position'] : 'slide';

        $this->add_render_attribute('jltma_offcanvas_content', 'class', array(
            'jltma-offcanvas-menu__content',
            'jltma-offcanvas-content-' . $this->get_id(),
            'jltma-canvas-animation-type-' . esc_attr($animation_type),
            'jltma-canvas-position-' . esc_attr($canvas_position),
        ));

        echo '<div ' . $this->get_render_attribute_string('jltma_offcanvas_content') . '>';
        $this->get_close();

        foreach ($settings['content_block'] as $item) {
            if ('' !== $item['box_to_down']) {
                $this->box_to_down_count++;
            }
        }

        $content_block_all_down = '';

        if (count($settings['content_block']) === $this->box_to_down_count) {
            $content_block_all_down = ' jltma-block-all-down';
        }

        echo '<div class="jltma-offcanvas-menu__body">' .
            '<div class="jltma-offcanvas-menu__body-container' . esc_attr($content_block_all_down) . '">';

        foreach ($settings['content_block'] as $item) {
            if ('' === $item['box_to_down']) {
                $item['box_to_down'] = 'false';
            }

            $item_bg_enable = ('yes' === $item['offcanvas_item_style'] && '' !== $item['content_custom_bg'] ? ' jltma_item_bg_enable' : '');

            echo '<div class="jltma-offcanvas-menu__custom-container ' . 'elementor-repeater-item-' . esc_attr($item['_id']) . ' jltma-box-down-' . esc_attr($item['box_to_down']) . '">';

            echo '<div class="jltma-offcanvas-menu__custom-container-cont">' . '<div class="jltma-offcanvas-menu__custom-container-cont-inner' . esc_attr($item_bg_enable) . '">';

            if ('' !== $item['title']) {
                echo '<h3 class="jltma-offcanvas-menu__custom-widget-title">' . esc_html($item['title']) . '</h3>';
            }

            switch ($item['content_type']) {
                case 'logo':

                    echo '<div class="jltma-offcanvas-menu__site-logo">';

                    $logo_image_source = (isset($item['logo_image_source']) ? $item['logo_image_source'] : '');
                    $site_logo_type = 'image';
                    $logo_type = (isset($item['logo_type']) ? $item['logo_type'] : '');

                    if (
                        ('default' === $logo_image_source && 'image' === $site_logo_type) ||
                        ('custom' === $logo_image_source && 'image' === $logo_type && !empty($this->get_logo_wrapper($item)))
                    ) {
                        $this->get_logo_wrapper($item);
                    }

                    if (
                        ('default' === $logo_image_source && 'text' === $site_logo_type) ||
                        ('custom' === $logo_image_source && 'text' === $logo_type)
                    ) {
                        $this->get_text_wrapper($item);
                    }

                    echo '</div>';

                    break;
                case 'custom':
                    echo '<div class="jltma-offcanvas-menu__custom-widget-content">' . $this->parse_text_editor($item['description']) . '</div>';

                    break;
                case 'navigation':
                    if (!$this->get_available_menus()) {
                        break;
                    }

                    $args = array(
                        'menu' => $item['nav_menu'],
                        'menu_id' => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
                        'menu_class' => 'jltma-offcanvas-menu__menu-inner',
                        'container' => '',
                        'echo' => false,
                        'fallback_cb' => '__return_empty_string',
                    );

                    $menu_html = wp_nav_menu($args);

                    if (empty($menu_html)) {
                        break;
                    }

                    echo '<nav class="jltma-offcanvas-menu__menu-container">' . wp_kses_post($menu_html) . '</nav>';

                    break;
                case 'sidebar':
                    global $wp_registered_sidebars;

                    if (!$wp_registered_sidebars) {
                        break;
                    }

                    echo $this->get_dynamic_sidebar($item['sidebar']);

                    break;
                case 'section':
                case 'template':
                case 'widget':
                    $content_type = $item['content_type'];

                    if ('template' === $content_type) {
                        $template_id = $item['template_id'];
                        $template_name = 'Saved Page';
                    } elseif ('section' === $content_type) {
                        $template_id = $item["saved_{$content_type}"];
                        $template_name = 'Saved Section';
                    } else {
                        $template_id = $item["saved_{$content_type}"];
                        $template_name = 'Global Widget';
                    }

                    if ('-1' === $template_id || !$template_id) {
                        if (is_admin()) {
                            /* translators: Offcanvas widget template not selected warning. %s: Name of content type */
                            Master_Addons_Helper::jltma_render_alert(sprintf(esc_html__('Please choose your %s template!', 'master-addons' ), $template_name));
                        }

                        break;
                    }

                    echo $this->get_widget_template($template_id, $content_type);

                    break;
            }

            echo '</div>' .
                '</div>' .
                '</div>';
        }

        echo '</div>' .
            '</div>' .
            '</div>';
    }



    /**
     * Returns logo
     *
     * @return string Image logo HTML markup.
     * Added get logo wrapper for content type `Site Logo`.
     */
    public function get_logo_wrapper($item)
    {
        $logo_image_source = (isset($item['logo_image_source']) ? $item['logo_image_source'] : '');
        $site_logo_type = 'image';
        $logo_type = (isset($item['logo_type']) ? $item['logo_type'] : '');
        $logo_image = (isset($item['logo_image']) ? $item['logo_image']['id'] : '');

        $is_linked = $this->get_is_linked($item);

        if (
            ('default' === $logo_image_source && 'image' === $site_logo_type) ||
            ('custom' === $logo_image_source && 'image' === $logo_type && '' !== $logo_image) ||
            ('custom' === $logo_image_source && 'image' === $logo_type && '' === $logo_image && 'image' === $site_logo_type)
        ) {
            echo ($is_linked ? $this->is_linked_start($item) : '');

            $this->get_logo_image_retina($item);

            $this->get_logo_image($item);

            echo ($is_linked ? '</a>' : '');
        }
    }



    /**
     * Get logo image
     *
     * @return string Get Logo Image
     * Added get logo image for content type `Site Logo`.
     */
    public function get_logo_image($item)
    {
        $logo_image_source = (isset($item['logo_image_source']) ? $item['logo_image_source'] : '');
        $site_logo_type = 'image';
        $site_logo =  array('url' => '');
        $site_logo_url = (isset($site_logo['url']) ? $site_logo['url'] : '');
        $logo_type = (isset($item['logo_type']) ? $item['logo_type'] : '');
        $logo_image = (isset($item['logo_image']) ? $item['logo_image']['id'] : '');
        $image_logo_url = '';

        if ('' === $site_logo_url) {
            $site_logo_url = JLTMA_IMAGE_DIR . 'logo.png';
        }

        // Get Logo URL
        if (('default' === $logo_image_source &&
            'image' === $site_logo_type) || ('custom' === $logo_image_source &&
            'image' === $logo_type &&
            '' === $logo_image &&
            'image' === $site_logo_type &&
            '' !== $site_logo_url)) {
            $image_logo_url = $site_logo_url;
        }

        if ('custom' === $logo_image_source && 'image' === $logo_type && '' !== $logo_image) {
            $image_logo = wp_get_attachment_image_src($logo_image, 'full');
            $image_logo_url = $image_logo[0];
        }

        // Render Image or Icon Logo
        if ('' !== $image_logo_url) {
            echo '<img' .
                ' src="' . esc_url($image_logo_url) . '"' .
                ' class="jltma-offcanvas-menu__site-logo-img"' .
                ' alt="' . esc_attr($this->get_logo_title_text($item)) . '" />';
        }
    }

    /**
     * Get logo image
     *
     * @return string Get Logo Image
     * Added get logo image retina for content type `Site Logo`.
     */
    public function get_logo_image_retina($item)
    {
        // Get Logo Retina URL
        $logo_image_source       = (isset($item['logo_image_source']) ? $item['logo_image_source'] : '');
        $logo_type               = (isset($item['logo_type']) ? $item['logo_type'] : '');
        $logo_retina             = (isset($item['logo_image_2x']) ? $item['logo_image_2x']['url'] : '');
        $site_logo_type          = 'image';
        $site_logo_retina_toggle = $item['logo_image_retina'];
        $site_logo_retina        = array('url' => '');
        $site_logo_retina_url    = (isset($site_logo_retina['url']) ? $site_logo_retina['url'] : '');
        $logo_image              = (isset($item['logo_image']) ? $item['logo_image']['id'] : '');
        $logo_retina_url         = '';


        if (('default' === $logo_image_source &&
            'image' === $site_logo_type &&
            'yes' === $site_logo_retina_toggle) || ('custom' === $logo_image_source &&
            'image' === $logo_type &&
            ('' === $logo_image || ('' !== $logo_image && empty($logo_retina))) &&
            'image' === $site_logo_type &&
            'yes' === $site_logo_retina_toggle)) {
            $logo_retina_url = $site_logo_retina_url;

            $site_logo_retina_size = getimagesize($logo_retina_url);
            $width = round($site_logo_retina_size[0] / 2);
            $height = round($site_logo_retina_size[1] / 2);
        }

        if (
            'custom' === $logo_image_source &&
            'image' === $logo_type &&
            '' !== $logo_image &&
            (isset($logo_retina) && !empty($logo_retina))
        ) {
            $logo_retina_url = $logo_retina;

            $image_logo_url = wp_get_attachment_image_src($item['logo_image_2x']['id'], 'full');

            $width = isset($image_logo_url[1]) ? round($image_logo_url[1] / 2) : '';
            $height = isset($image_logo_url[2]) ? round($image_logo_url[2] / 2) : '';
        }

        // Render Image or Icon Logo
        if (isset($logo_retina_url) && '' !== $logo_retina_url) {
            echo '<img' .
                ' src="' . esc_url($logo_retina_url) . '"' .
                ' class="jltma-offcanvas-menu__site-logo-retina-img"' .
                ' alt="' . esc_attr($this->get_logo_title_text($item)) . '"' .
                ' width="' . esc_attr($width) . '"' .
                ' height="' . esc_attr($height) . '" />';
        }
    }

    /**
     * Check if logo is linked.
     *
     * @return bool
     * Added link check for logo in content type `Site Logo`.
     */
    public function get_is_linked($item)
    {
        if ('none' === $item['logo_link']) {
            return false;
        }

        return true;
    }

    /**
     * Check if logo is linked.
     *
     * @return bool
     * Added get link for logo in content type `Site Logo`.
     */
    public function is_linked_start($item)
    {
        $link = '';
        $logo_link = isset($item['logo_link']) ? esc_attr($item['logo_link']) : 'none';

        if ('home' === $logo_link) {

            $link .= '<a href="' . home_url() . '" class="jltma-offcanvas-menu__site-logo-link">';
        } elseif ('custom' === $logo_link) {
            $logo_custom_url = (isset($item['logo_custom_url']) ? esc_attr($item['logo_custom_url']['url']) : '');

            if ('' !== $logo_custom_url) {
                $link .= '<a' .
                    ' href="' . esc_url($logo_custom_url) . '"' .
                    ' class="jltma-offcanvas-menu__site-logo-link"' .
                    ($item['logo_custom_url']['is_external'] ? ' target="_blank"' : '') .
                    ($item['logo_custom_url']['nofollow'] ? ' rel="nofollow"' : '') .
                    '>';
            }
        }

        return $link;
    }


    /**
     * Returns logo text
     *
     * @return string Text logo HTML markup.
     * Added get text wrapper for content type `Site Logo`.
     */
    public function get_text_wrapper($item)
    {
        $is_linked = $this->get_is_linked($item);

        echo '<h1 class="jltma-offcanvas-menu__site-logo-title">' .
            ($is_linked ? $this->is_linked_start($item) : '') .
            $this->get_logo_title_text($item) .
            ($is_linked ? '</a>' : '') .
            '</h1>';
    }

    /**
     * Returns logo text
     *
     * @return string Text logo HTML markup.
     * Added get logo title text for content type `Site Logo`.
     */
    public function get_logo_title_text($item)
    {
        $logo_type = (isset($item['logo_type']) ? $item['logo_type'] : '');
        $title = get_bloginfo('name');
        $logo_title = (isset($item['logo_title']) ? $item['logo_title'] : '');
        $site_logo_title_text = '';

        if ('image' !== $logo_type) {
            if ('image' !== $logo_type && '' !== $logo_title) {
                $title = esc_html($logo_title);
            }

            if ('' === $logo_title && '' !== $site_logo_title_text) {
                $title = esc_html($site_logo_title_text);
            }
        }

        return $title;
    }

    /**
     * Return close button output on the frontend.
     * Written in PHP and used to generate the final HTML.
     */
    public function get_close()
    {
        $settings = $this->get_settings_for_display();
        $close_button_vertical_alignment = $settings['close_button_vertical_alignment'] ? $settings['close_button_vertical_alignment'] : 'top';
        $this->add_render_attribute('jltma_offcanvas_close_container', 'class', array(
            'jltma-offcanvas-menu__close-container',
            'jltma-close-hor-align-' . esc_attr($settings['close_button_horizontal_alignment']),
            'jltma-close-ver-align-' . esc_attr($close_button_vertical_alignment),
            'jltma-position-' . esc_attr($settings['close_button_position']),
            'jltma-close-view-' . esc_attr($settings['close_button_view']),
        ));

        $close_button_shape = $settings['close_button_shape'];

        if (isset($close_button_shape)) {
            $this->add_render_attribute('jltma_offcanvas_close_container', 'class', 'jltma-close-shape-' . esc_attr($close_button_shape));
        }

        echo '<div ' . $this->get_render_attribute_string('jltma_offcanvas_close_container') . '>' .
            '<div class="jltma-offcanvas-menu__close">';

        $close_button_type = $settings['close_button_type'];

        if ('text' !== $close_button_type) {
            $close_button_icon = $settings['close_button_icon'];

            if ('' !== $close_button_icon['value']) {
                echo '<span class="jltma-offcanvas-menu__close-icon">';
                Icons_Manager::render_icon($close_button_icon);
                echo '</span>';
            } else {
                echo '<span class="jltma-offcanvas-menu__close-icon">' .
                    '<i class="eicon-close"></i>' .
                    '</span>';
            }
        }

        if ('icon' !== $close_button_type) {
            echo '<span class="jltma-offcanvas-menu__close-label">';

            $close_button_text = $settings['close_button_text'];

            if ('' !== $close_button_text) {
                echo esc_html($close_button_text);
            } else {
                echo esc_html__('Close', 'master-addons' );
            }

            echo '</span>';
        }

        echo '</div>' .
            '</div>';
    }

    protected $nav_menu_index = 1;

    protected function get_nav_menu_index()
    {
        return $this->nav_menu_index++;
    }

    /**
     * Render Output for Frontend
     */
    protected function render()
    {
        $settings = $this->get_active_settings();
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => [ 'jltma-offcanvas-menu__wrapper' ],
                'data-settings' => wp_json_encode([
                    'animation_type' => $settings['animation_type'],
                    'canvas_position' => $settings['canvas_position']
                ])
            ]
        );
        echo '<div '.$this->get_render_attribute_string( 'wrapper' ).'">';

        $this->get_trigger();

        $this->get_content();

        echo '</div>';
    }
}

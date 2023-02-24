<?php

namespace MasterAddons\Modules;

// Elementor classes
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Core\Schemes\Color;
use \Elementor\Utils;
use \MasterAddons\Inc\Classes\JLTMA_Extension_Prototype;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Tooltip Extension
 * Adds tooltip capability to widgets
 */
class JLTMA_Extension_Tooltip extends JLTMA_Extension_Prototype
{

    private static $instance = null;
    public $name = 'Tooltip';
    public $has_controls = true;

    public $common_sections_actions = array(
        array(
            'element' => 'common',
            'action' => '_section_style',
        ),

        array(
            'element' => 'column',
            'action' => 'section_advanced',
        ),
    );


    private function add_controls($element, $args)
    {

        $element_type = $element->get_type();

        $element->add_control(
            'jltma_element_tooltip_enable',
            [
                'label'              => __('Tooltip', 'master-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'label_on'           => __('Yes', 'master-addons' ),
                'label_off'          => __('No', 'master-addons' ),
                'return_value'       => 'yes',
                'frontend_available' => true,
            ]
        );

        $element->start_controls_tabs('tooltip_element_settings');

        $element->start_controls_tab('tooltip_element_settings_tab', [
            'label'     => __('Settings', 'master-addons' ),
            'condition' => [
                'jltma_element_tooltip_enable' => 'yes',
            ],
        ]);

        $element->add_control(
            'jltma_element_tooltip_text',
            [
                'label'              => esc_html__('Content', 'master-addons' ),
                'type'               => Controls_Manager::TEXTAREA,
                'default'            => __('This is Element Tooltip', 'master-addons' ),
                'dynamic'            => ['active' => true],
                'condition'          => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'jltma_element_tooltip_placement',
            [
                'label'   => esc_html__('Placement', 'master-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top'       => esc_html__('Top (Default)', 'master-addons' ),
                    'top-start' => esc_html__('Top Start', 'master-addons' ),
                    'top-end'   => esc_html__('Top End', 'master-addons' ),

                    'right'       => esc_html__('Right', 'master-addons' ),
                    'right-start' => esc_html__('Right Start', 'master-addons' ),
                    'right-end'   => esc_html__('Right End', 'master-addons' ),

                    'bottom'       => esc_html__('Bottom', 'master-addons' ),
                    'bottom-start' => esc_html__('Bottom Start', 'master-addons' ),
                    'bottom-end'   => esc_html__('Bottom End', 'master-addons' ),

                    'left'       => esc_html__('Left', 'master-addons' ),
                    'left-start' => esc_html__('Left Start', 'master-addons' ),
                    'left-end'   => esc_html__('Left End', 'master-addons' ),

                    'auto'       => esc_html__('Auto', 'master-addons' ),
                    'auto-start' => esc_html__('Auto Start', 'master-addons' ),
                    'auto-end'   => esc_html__('Auto End', 'master-addons' ),
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'jltma_element_tooltip_enable'        => 'yes',
                    'jltma_element_tooltip_follow_cursor' => ''
                ],
            ]
        );

        $element->add_control(
            'jltma_element_tooltip_follow_cursor',
            [
                'label'              => esc_html__('Follow Cursor', 'master-addons' ) . JLTMA_NF,
                'type'               => Controls_Manager::SWITCHER,
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'jltma_element_tooltip_enable'               => 'yes',
                ],
            ]
        );


        $element->add_control(
            'jltma_element_tooltip_animation',
            [
                'label'   => esc_html__('Animation', 'master-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'scale',
                'options' => [
                    'none'         => esc_html__('None', 'master-addons' ),
                    ''             => esc_html__('Fade', 'master-addons' ),
                    'shift-away'   => esc_html__('Shift-Away', 'master-addons' ),
                    'shift-toward' => esc_html__('Shift-Toward', 'master-addons' ),
                    'scale'        => esc_html__('Scale', 'master-addons' ),
                    'perspective'  => esc_html__('Perspective', 'master-addons' ),
                    'fill'         => esc_html__('Fill Effect', 'master-addons' ),
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );


        $element->add_control(
            'jltma_element_tooltip_trigger',
            [
                'label'   => esc_html__('Trigger', 'master-addons' ) . JLTMA_NF,
                'type'    => Controls_Manager::SELECT,
                'default' => 'mouseenter',
                'options' => [
                    'mouseenter' => esc_html__('Hover', 'master-addons' ),
                    'click'      => esc_html__('Click', 'master-addons' ),
                    'manual'     => esc_html__('Custom Trigger', 'master-addons' ),

                ],
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'jltma_element_tooltip_custom_trigger',
            [
                'label'              => esc_html__('Custom Trigger', 'master-addons' ),
                'placeholder'        => '.class-name',
                'type'               => Controls_Manager::TEXT,
                'dynamic'            => ['active' => true],
                'condition'          => [
                    'jltma_element_tooltip_enable' => 'yes',
                    'jltma_element_tooltip_trigger' => 'manual',
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'jltma_element_tooltip_duration',
            [
                'label'              => __('Duration', 'master-addons' ),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 100,
                'max'                => 1000,
                'step'               => 10,
                'default'            => 300,
                'frontend_available' => true,
                'condition'          => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'jltma_element_tooltip_delay',
            [
                'label'              => __('Delay out (s)', 'master-addons' ),
                'type'               => Controls_Manager::NUMBER,
                'min'                => 100,
                'max'                => 1000,
                'step'               => 5,
                'default'            => 400,
                'frontend_available' => true,
                'condition'          => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );


        $element->add_control(
            'jltma_element_tooltip_x_offset',
            [
                'label'              => esc_html__('X Offset', 'master-addons' ),
                'type'               => Controls_Manager::SLIDER,
                'size_units'         => ['px'],
                'range'              => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'jltma_element_tooltip_y_offset',
            [
                'label'              => esc_html__('Y Offset', 'master-addons' ),
                'type'               => Controls_Manager::SLIDER,
                'size_units'         => ['px'],
                'range'              => [
                    'px' => [
                        'min'  => -1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );


        $element->add_control(
            'jltma_element_tooltip_arrow',
            [
                'label'              => esc_html__('Arrow', 'master-addons' ),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => true,
                'render_type'        => 'none',
                'frontend_available' => true,
                'condition'          => [
                    'jltma_element_tooltip_enable'     => 'yes',
                    'jltma_element_tooltip_animation!' => 'fill'
                ],
            ]
        );

        $element->add_control(
            'jltma_element_tooltip_arrow_type',
            [
                'label' => __('Arrow Type', 'master-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'sharp',
                'options' => [
                    'sharp' => __('Sharp', 'master-addons' ),
                    'round' => __('Round', 'master-addons' ),
                ],
                'frontend_available' => true,
                'condition' => [
                    'jltma_element_tooltip_enable'     => 'yes',
                    'jltma_element_tooltip_arrow!' => '',
                ],
            ]
        );


        $element->update_control(
            'tooltip_target',
            [
                'options' => array(
                    'element' => ucfirst($element_type),
                ),
            ],
            [
                'recursive' => true,
            ]
        );

        $element->end_controls_tab();


        $element->start_controls_tab('tooltip_element_style_tab', [
            'label'     => __('Style', 'master-addons' ),
            'condition'    => [
                'jltma_element_tooltip_enable' => 'yes',
            ],
        ]);

        $element->add_responsive_control(
            'jltma_element_tooltip_width',
            [
                'label'       => esc_html__('Max Width', 'master-addons' ),
                'type'        => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '350',
                ],
                'size_units'  => [
                    'px',
                    'em',
                ],
                'range'       => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                    ],
                ],
                'selectors'          => [
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'   => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );



        $element->add_control(
            'jltma_element_tooltip_color',
            [
                'label'     => esc_html__('Text Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box .tippy-content' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'jltma_element_tooltip_background',
            [
                'label'     => __('Background Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box'                                      => 'background-color: {{VALUE}};',
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box[data-placement^=top] .tippy-arrow, [data-jltma-tippy-id="{{ID}}"] .tippy-box[data-placement^=bottom] .tippy-arrow, [data-jltma-tippy-id="{{ID}}"] .tippy-box[data-placement^=left] .tippy-arrow, [data-jltma-tippy-id="{{ID}}"] .tippy-box[data-placement^=right] .tippy-arrow'    => 'color: {{VALUE}};',
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box .tippy-svg-arrow'                    => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'jltma_element_tooltip_arrow_color',
            [
                'label'     => esc_html__('Arrow Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box[data-placement^=top]>.tippy-arrow:before'    => 'border-top-color: {{VALUE}};',
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box[data-placement^=bottom]>.tippy-arrow:before' => 'border-bottom-color: {{VALUE}};',
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box[data-placement^=left]>.tippy-arrow:before'   => 'border-left-color: {{VALUE}};',
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box[data-placement^=righ]>.tippy-arrow:before'   => 'border-righ-color: {{VALUE}};',
                ],
                'condition' => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
                'separator' => 'after',
            ]
        );

        $element->add_responsive_control(
            'jltma_element_tooltip_padding',
            [
                'label'      => __('Padding', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'jltma_element_tooltip_border',
                'label'       => esc_html__('Border', 'master-addons' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '[data-jltma-tippy-id="{{ID}}"] .tippy-box',
                'condition'   => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );

        $element->add_responsive_control(
            'jltma_element_tooltip_border_radius',
            [
                'label'      => __('Border Radius', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );


        $element->add_control(
            'jltma_element_tooltip_text_align',
            [
                'label'     => esc_html__('Text Alignment', 'master-addons' ),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'center',
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'master-addons' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'master-addons' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'master-addons' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '[data-jltma-tippy-id="{{ID}}"] .tippy-box .tippy-content' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
                'separator' => 'before',
            ]
        );

        $element->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'jltma_element_tooltip_box_shadow',
                'selector' => '[data-jltma-tippy-id="{{ID}}"] .tippy-box',
                'condition' => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'jltma_element_tooltip_typography',
                'selector' => '[data-jltma-tippy-id="{{ID}}"] .tippy-box',
                'condition' => [
                    'jltma_element_tooltip_enable' => 'yes',
                ],
            ]
        );

        $element->end_controls_tab();

        $element->end_controls_tabs();
    }


    public function jltma_tooltip_scripts()
    {
        wp_register_script('jltma-section-tooltip', JLTMA_URL . '/assets/js/extensions/ma-tooltips.js', ['jquery'], JLTMA_VER, true);
        wp_enqueue_script('jltma-section-tooltip');
    }


    protected function add_actions()
    {
        // Activate controls for widgets
        add_action('elementor/element/common/jltma_section_tooltip_advanced/before_section_end', function ($element, $args) {
            $this->add_controls($element, $args);
        }, 10, 3);
        add_action('elementor/frontend/widget/before_render', [$this, 'before_render'], 10, 2);
        add_action('elementor/frontend/widget/after_render', [$this, 'after_render'], 10, 1);

        add_action('elementor/preview/enqueue_scripts', [$this, 'jltma_tooltip_scripts']);
    }

    public function before_render($element)
    {
        $settings = $element->get_settings_for_display();
        if ($settings['jltma_element_tooltip_enable'] == 'yes') {
            $element->add_render_attribute('_wrapper', [
                'id' => 'jltma-section-tooltip-' . $element->get_id(),
                'class' => 'jltma-section-tooltip',
            ]);

            wp_enqueue_script('jltma-popper');
            wp_enqueue_script('jltma-tippy');
            wp_enqueue_style('jltma-tippy');
        }
    }


    public function after_render($element)
    {
        $settings = $element->get_settings_for_display();

        if ($settings['jltma_element_tooltip_enable'] === 'yes') {
            $data    = $element->get_data();
            $content = wp_kses_post($settings['jltma_element_tooltip_text']);

            $follow_cursor        = $settings["jltma_element_tooltip_follow_cursor"] ? 'true' : 'false';
            $position             = $settings["jltma_element_tooltip_placement"] ? $settings["jltma_element_tooltip_placement"] : 'top';
            $animation            = $settings['jltma_element_tooltip_animation'];
            $duration             = $settings["jltma_element_tooltip_duration"];
            $delay                = $settings["jltma_element_tooltip_delay"];
            $arrow                = ($settings["jltma_element_tooltip_arrow"]) ? 'true' : 'false';
            $arrowType            = $settings["jltma_element_tooltip_arrow_type"];
            $trigger              = $settings["jltma_element_tooltip_trigger"];
            $custom_trigger       = $settings["jltma_element_tooltip_custom_trigger"];
            $width                = $settings["jltma_element_tooltip_width"];
            $x_offset             = $settings["jltma_element_tooltip_x_offset"]['size'] ? $settings["jltma_element_tooltip_x_offset"]['size'] : 0;
            $y_offset             = $settings["jltma_element_tooltip_y_offset"]['size'] ? $settings["jltma_element_tooltip_y_offset"]['size'] : 0;
            $arrow = (($arrow === 'true') && ($arrowType === 'round')) ? 'tippy.roundArrow' : $arrow;
?>

            <script>
                jQuery(document).ready(function() {
                    jQuery(window).on('elementor/frontend/init', function() {
                        var $trigger_type = '<?php echo esc_attr($trigger); ?>';
                        var $currentTooltip = '#jltma-section-tooltip-<?php echo esc_attr($element->get_id()); ?>';
                        // if trigger 'manual'
                        if ($trigger_type == 'manual') {
                            var $custom_trigger = document.querySelector('<?php echo esc_attr($custom_trigger); ?>');
                            $currentTooltip = $custom_trigger;
                            $currentTooltip.addEventListener("click", function() {
                                $ma_tippy.show(300);
                                setTimeout(function() {
                                    $ma_tippy.hide(300);
                                }, 1500);
                            });
                        }
                        var $ma_tippy = tippy($currentTooltip, {
                            content: '<?php echo (str_replace("'", "\'", $content)); ?>',
                            placement: '<?php echo esc_attr($position); ?>',
                            followCursor: <?php echo esc_attr($follow_cursor); ?>,
                            animation: '<?php echo esc_attr($animation); ?>',
                            arrow: <?php echo esc_attr($arrow); ?>,
                            duration: '<?php echo esc_attr($duration); ?>',
                            delay: '<?php echo esc_attr($delay); ?>',
                            trigger: $trigger_type,
                            // animateFill: true,
                            flipOnUpdate: true,
                            interactive: true,
                            offset: [<?php echo esc_attr($x_offset); ?>, <?php echo esc_attr($y_offset); ?>],
                            maxWidth: <?php echo esc_attr($width['size']); ?>,
                            zIndex: 999,
                            allowHTML: true,
                            theme: '<?php echo 'jltma-section-tippy-' . esc_attr($data['id']); ?>',
                            appendTo: 'parent',
                            onShow(instance) {
                                var tippyPopper = instance.popper;
                                jQuery(tippyPopper).attr('data-jltma-tippy-id', '<?php echo esc_attr($data['id']); ?>');
                            }
                        });
                    });
                });
            </script>
<?php }
    }


    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

JLTMA_Extension_Tooltip::get_instance();

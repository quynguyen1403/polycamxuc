<?php

namespace MasterAddons\Addons;

// Elementor Classes
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Text_Shadow;

/**
 * Author Name: Liton Arefin
 * Author URL : https://master-addons.com
 * Date       : 02/04/2020
 */

if (!defined('ABSPATH')) exit; // If this file is called directly, abort.

class JLTMA_Domain_Search extends Widget_Base
{

    public function get_name()
    {
        return 'jltma_domain_checker';
    }

    public function get_title()
    {
        return esc_html__('Domain Checker', 'master-addons');
    }

    public function get_icon()
    {
        return 'jltma-icon eicon-check-circle';
    }

    public function get_categories()
    {
        return ['master-addons'];
    }


    public function get_help_url()
    {
        return 'https://master-addons.com/demos/domain-search/';
    }

    protected function register_controls()
    {

        /**
         * Master Addons: Domain Checker
         */
        $this->start_controls_section(
            'ma_el_domain_checker_content',
            [
                'label' => esc_html__('General', 'master-addons'),
            ]
        );

        $this->add_control(
            'palceholder_text',
            array(
                'label'       => __('Input Placeholder', 'master-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Enter Your Domain Here',
                'label_block' => true
            )
        );

        $this->add_control(
            'ma_el_domain_checker_submit_type',
            array(
                'label'   => __('Submit Button Type', 'master-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => array(
                    'icon' => __('Icon', 'master-addons'),
                    'text' => __('Button', 'master-addons'),
                )
            )
        );
        $this->add_control(
            'ma_el_domain_checker_submit_button_text',
            array(
                'label'       => __('Button Text', 'master-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Search',
                'label_block' => true,
                'condition'   => array(
                    'ma_el_domain_checker_submit_type' => 'text'
                )
            )
        );


        $this->add_control(
            'ma_el_domain_checker_submit_button',
            [
                'label'              => esc_html__('Button Link?', 'master-addons'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => '',
                'label_on'           => esc_html__('Yes', 'master-addons'),
                'label_off'          => esc_html__('No', 'master-addons'),
                'return_value'       => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'ma_el_domain_checker_submit_button_url',
            [
                'label'   => __('Action URL', 'master-addons'),
                'type'    => Controls_Manager::URL,
                'default' => [
                    'is_external' => true,
                ],
                'placeholder' => __('http://your-link.com', 'master-addons'),
                'separator'   => 'before',
                'condition'   => [
                    'ma_el_domain_checker_submit_button' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'ma_el_domain_checker_submit_icon',
            array(
                'label'            => __('Icon', 'master-addons'),
                'description'      => __('Please choose an icon from the list.', 'master-addons'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'   => 'fa fa-search',
                    'library' => 'fa-solid',
                ],
                'render_type' => 'template',
                'condition'   => array(
                    'ma_el_domain_checker_submit_type' => 'icon'
                )
            )
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'ma_el_domain_checker_messages',
            [
                'label' => esc_html__('Messages', 'master-addons'),
            ]
        );

        $this->add_control(
            'ma_el_domain_checker_success',
            array(
                'label'       => __('Success Message', 'master-addons'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __('Congratulations! &percnt;s is available!', 'master-addons'),
                'description' => __('Attention: &percnt;s is required to print dynamic data. It will print Domain name.', 'master-addons'),
                'label_block' => true
            )
        );

        $this->add_control(
            'ma_el_domain_checker_error',
            array(
                'label'       => __('Error Message', 'master-addons'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __('Sorry! &percnt;s is already taken!', 'master-addons'),
                'description' => __('Attention: &percnt;s is required to print dynamic data. It will print Domain name.', 'master-addons'),
                'label_block' => true
            )
        );

        $this->add_control(
            'ma_el_domain_not_found',
            array(
                'label'       => __('Not Found', 'master-addons'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __('WHOIS server not found for that TLD.', 'master-addons'),
                'label_block' => true
            )
        );

        $this->add_control(
            'ma_el_domain_not_entered',
            array(
                'label'       => __('Not Entered Domain Name', 'master-addons'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __('Please Enter a Domain name.', 'master-addons'),
                'label_block' => true
            )
        );

        $this->end_controls_section();


        /* Affiliation */
        $this->start_controls_section(
            'ma_el_domain_checker_affiliation',
            [
                'label' => esc_html__('Affiliation', 'master-addons'),
            ]
        );


        $this->add_control(
            'ma_el_domain_affiliate_show',
            [
                'label'        => esc_html__('Show Affiliate Link?', 'master-addons'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'master-addons'),
                'label_off'    => esc_html__('Hide', 'master-addons'),
                'return_value' => 'yes',
                'default'      => 'No'
            ]
        );

        $this->add_control(
            'ma_el_domain_affiliate_text',
            array(
                'label'       => __('Affiliate Text', 'master-addons'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'Enter Your Domain Here',
                'default'     => 'Sign Up',
                'label_block' => true,
                'condition'   => [
                    'ma_el_domain_affiliate_show' => 'yes'
                ]
            )
        );

        $this->add_control(
            'ma_el_domain_affiliate_link',
            array(
                'label'       => __('Affiliate Link', 'master-addons'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => ['active' => true],
                'placeholder' => 'http://master-addons.com',
                'label_block' => true,
                'condition'   => [
                    'ma_el_domain_affiliate_show' => 'yes'
                ]
            )
        );

        $this->end_controls_section();


        /*  button_style_section
            /*-------------------------------------*/

        $this->start_controls_section(
            'button_style_section',
            array(
                'label' => __('Button', 'master-addons'),
                'tab'   => Controls_Manager::TAB_STYLE
            )
        );

        $this->start_controls_tabs('button_background_tab');

        $this->start_controls_tab(
            'button_bg_normal',
            array(
                'label' => __('Normal', 'master-addons')
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'button_background',
                'label'    => __('Background', 'master-addons'),
                'types'    => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .jltma-button',
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .jltma-button'
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_bg_hover',
            array(
                'label' => __('Hover', 'master-addons')
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'hover_button_background',
                'label'    => __('Background', 'master-addons'),
                'types'    => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .jltma-button .jltma-overlay::after',
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'hover_button_box_shadow',
                'selector' => '{{WRAPPER}} .jltma-button:hover'
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'button_text_heading',
            array(
                'label'     => __('Button Text', 'master-addons'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            )
        );

        $this->start_controls_tabs('button_text_style');

        $this->start_controls_tab(
            'button_text_normal',
            array(
                'label' => __('Normal', 'master-addons')
            )
        );

        $this->add_control(
            'btn_text_color',
            array(
                'label'     => __('Color', 'master-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .jltma-button span' => 'color: {{VALUE}};',
                )
            )
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            array(
                'name'     => 'btn_text_shadow',
                'label'    => __('Text Shadow', 'master-addons'),
                'selector' => '{{WRAPPER}} .jltma-button',
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'scheme'   => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .jltma-button span'
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_text_hover',
            array(
                'label' => __('Hover', 'master-addons')
            )
        );

        $this->add_control(
            'hover_btn_text_color',
            array(
                'label'     => __('Color', 'master-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .jltma-button:hover .jltma-button span' => 'color: {{VALUE}};',
                )
            )
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            array(
                'name'     => 'hover_btn_text_shadow',
                'label'    => __('Text Shadow', 'master-addons'),
                'selector' => '{{WRAPPER}} .jltma-button:hover',
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'hover_button_typography',
                'scheme'   => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .jltma-button span'
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            array(
                'label'      => __('Padding', 'master-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors'  => array(
                    '{{WRAPPER}} .jltma-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                )
            )
        );

        $this->add_responsive_control(
            'button_margin',
            array(
                'label'      => __('Margin', 'master-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors'  => array(
                    '{{WRAPPER}} .jltma-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                )
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'jltma_counterup_border',
                'label'    => esc_html__('Border Type', 'master-addons'),
                'selector' => '{{WRAPPER}} .jltma-button',
            ]
        );

        $this->add_responsive_control(
            'ma_el_domain_checker',
            [
                'label'      => esc_html__('Border Radius', 'master-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .jltma-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();


        /*  loader_style_section
            /*-------------------------------------*/

        $this->start_controls_section(
            'loader_style_section',
            array(
                'label' => __('Loader', 'master-addons'),
                'tab'   => Controls_Manager::TAB_STYLE
            )
        );

        $this->add_control(
            'loader_color',
            array(
                'label'     => __('Color', 'master-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .jltma-button path, .jltma-button rect' => 'fill: {{VALUE}};',
                )
            )
        );

        $this->add_control(
            'loader_size',
            array(
                'label'   => __('Size', 'master-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => '24',
                'min'     => 16,
                'step'    => 1
            )
        );

        $this->end_controls_section();




        /**
         * Content Tab: Docs Links
         */
        $this->start_controls_section(
            'jltma_section_help_docs',
            [
                'label' => esc_html__('Help Docs', 'master-addons'),
            ]
        );


        $this->add_control(
            'help_doc_1',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(esc_html__('%1$s Live Demo %2$s', 'master-addons'), '<a href="https://master-addons.com/demos/domain-search/" target="_blank" rel="noopener">', '</a>'),
                'content_classes' => 'jltma-editor-doc-links',
            ]
        );

        $this->add_control(
            'help_doc_2',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(esc_html__('%1$s Documentation %2$s', 'master-addons'), '<a href="https://master-addons.com/docs/addons/how-ma-domain-checker-works/?utm_source=widget&utm_medium=panel&utm_campaign=dashboard" target="_blank" rel="noopener">', '</a>'),
                'content_classes' => 'jltma-editor-doc-links',
            ]
        );

        // $this->add_control(
        //     'help_doc_3',
        //     [
        //         'type'            => Controls_Manager::RAW_HTML,
        //         'raw'             => sprintf( esc_html__( '%1$s Watch Video Tutorial %2$s', 'master-addons' ), '<a href="https://www.youtube.com/watch?v=4xAaKRoGV_o" target="_blank" rel="noopener">', '</a>' ),
        //         'content_classes' => 'jltma-editor-doc-links',
        //     ]
        // );
        $this->end_controls_section();





        //Upgrade to Pro
        if (ma_el_fs()->is_not_paying()) {

            $this->start_controls_section(
                'jltma_section_pro_style_section',
                [
                    'label' => esc_html__('Upgrade to Pro for More Features', 'master-addons'),
                ]
            );

            $this->add_control(
                'jltma_control_get_pro_style_tab',
                [
                    'label'   => esc_html__('Unlock more possibilities', 'master-addons'),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        '1' => [
                            'title' => esc_html__('', 'master-addons'),
                            'icon'  => 'fa fa-unlock-alt',
                        ],
                    ],
                    'default'     => '1',
                    'description' => '<span class="pro-feature"> Upgrade to  <a href="' . ma_el_fs()->get_upgrade_url() . '" target="_blank">Pro Version</a> for more Elements with Customization Options.</span>'
                ]
            );

            $this->end_controls_section();
        }
    }

    protected function render()
    {
        $settings                    = $this->get_settings_for_display();
        $ma_el_domain_affiliate_text = $settings['ma_el_domain_affiliate_text'];
        $success_msg                 = ($settings['ma_el_domain_checker_success'] != "") ? $settings['ma_el_domain_checker_success'] : "";
        $error_msg                   = ($settings['ma_el_domain_checker_error'] != "") ? $settings['ma_el_domain_checker_error'] : "";
        $not_found_msg               = ($settings['ma_el_domain_not_found'] != "") ? $settings['ma_el_domain_not_found'] : "";
        $not_entered_domain          = ($settings['ma_el_domain_not_entered'] != "") ? $settings['ma_el_domain_not_entered'] : "";

        $this->add_render_attribute('domain_affiliate', 'class', ['inline-block']);

        if (!empty($settings['ma_el_domain_affiliate_link']['url'])) {
            $this->add_render_attribute('domain_affiliate', 'href', $settings['ma_el_domain_affiliate_link']['url']);

            if ($settings['ma_el_domain_affiliate_link']['is_external']) {
                $this->add_render_attribute('domain_affiliate', 'target', '_blank');
            }

            if ($settings['ma_el_domain_affiliate_link']['nofollow']) {
                $this->add_render_attribute('domain_affiliate', 'rel', 'nofollow');
            }
        }

        $ma_el_domain_affiliate = '';
        if ($settings['ma_el_domain_affiliate_show'] == "yes") {
            $ma_el_domain_affiliate = '<a ' . $this->get_render_attribute_string('domain_affiliate') . '>';
            $ma_el_domain_affiliate .= $ma_el_domain_affiliate_text;
            $ma_el_domain_affiliate .= '</a>';
        }


        if (!isset($settings['icon']) && !Icons_Manager::is_migration_allowed()) {
            $settings['icon'] = 'fa fa-search';
        }

        $has_icon = !empty($settings['icon']);
        if ($has_icon and 'icon' == $settings['ma_el_domain_checker_submit_type']) {
            $this->add_render_attribute('font-icon', 'class', $settings['ma_el_domain_checker_submit_icon']);
            $this->add_render_attribute('font-icon', 'aria-hidden', 'true');
        }

        if (!$has_icon && !empty($settings['ma_el_domain_checker_submit_icon']['value'])) {
            $has_icon = true;
        }

        // Submit Button Link
        $this->add_render_attribute('submit-button', 'class', ['jltma-btn', 'jltma-btn-dark', 'domain-checker', 'ma-el-button', 'ma-el-btn-loader']);
        if (!empty($settings['ma_el_domain_checker_submit_button_url']['url'])) {
            $this->add_render_attribute('submit-button', 'href', $settings['ma_el_domain_checker_submit_button_url']['url']);

            if (!empty($settings['ma_el_domain_checker_submit_button_url']['is_external'])) {
                $this->add_render_attribute('submit-button', 'target', '_blank');
            }
        }

        $migrated = isset($settings['__fa4_migrated']['ma_el_domain_checker_submit_icon']);
        $is_new   = empty($settings['icon']) && Icons_Manager::is_migration_allowed();
        ob_start(); ?>

        <div class="jltma-domain-checker">
            <div class="jltma-domain-checker-inner">
                <form method="post">
                    <div class="jltma-form-group">

                        <div class="jltma-input-group mb-3">
                            <input type="text" placeholder="<?php echo esc_attr($settings['palceholder_text']); ?>" class="jltma-form-control jltma-domain-name" autocomplete="off">
                            <div class="jltma-input-group-append">

                                <button type="submit" class="jltma-btn jltma-btn-dark domain-checker jltma-button jltma-btn-loader">
                                    <span>
                                        <?php if ($has_icon and 'icon' == $settings['ma_el_domain_checker_submit_type']) {
                                            if ($is_new || $migrated) {
                                                Icons_Manager::render_icon($settings['ma_el_domain_checker_submit_icon'], ['aria-hidden' => 'true']);
                                            } else {
                                                echo '<i ' . $this->get_render_attribute_string('font-icon') . '></i>';
                                            }
                                        } elseif ('text' == $settings['ma_el_domain_checker_submit_type']) {
                                            echo $this->parse_text_editor($settings['ma_el_domain_checker_submit_button_text']);
                                        } ?>
                                    </span>

                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="<?php echo esc_attr($settings['loader_size']); ?>px" height="<?php echo esc_attr($settings['loader_size']); ?>px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                                        <path opacity="0.2" fill="#ffffff" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                                                    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                                                    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
                                        <path fill="#ffffff" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                                                    C22.32,8.481,24.301,9.057,26.013,10.047z">
                                            <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
                                        </path>
                                    </svg>
                                </button>

                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <div class="jltma-results"></div>
        </div>



        <script>
            jQuery(function($) {
                $('.jltma-domain-checker').on('submit', function(event) {
                    event.preventDefault();
                    <?php
                    // Enable/Disable Ajax Script depending on Button URL
                    if ($settings['ma_el_domain_checker_submit_button'] != "yes") { ?>

                        var $this = $(this),
                            domain = $('.jltma-domain-name', $this).val(),
                            succes_msg = "<?php echo wp_kses_post($success_msg); ?>",
                            error_msg = "<?php echo wp_kses_post($error_msg); ?>",
                            not_found = "<?php echo wp_kses_post($not_found_msg); ?>",
                            not_entered_domain = "<?php echo wp_kses_post($not_entered_domain); ?>";
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: {
                                action: 'jltma_domain_checker',
                                domain: domain,
                                succes_msg: succes_msg,
                                error_msg: error_msg,
                                not_found: not_found,
                                not_entered_domain: not_entered_domain,
                                nonce: '<?php echo wp_create_nonce('jltma-domain-checker'); ?>'
                            },
                            beforeSend: function() {
                                $('.jltma-button', $this).addClass('jltma-svg-progress').prop('disabled', true);
                            }
                        }).then(function(response) {
                            $('.jltma-button', $this).removeClass('jltma-svg-progress').prop('disabled', false);
                            if (response.success) {
                                $('.jltma-results', $this).addClass("text-success").removeClass("text-danger").html(response.data + ' <?php echo isset($ma_el_domain_affiliate); ?>');
                            } else {
                                $('.jltma-results', $this).addClass("text-danger").removeClass("text-success").html(response.data);
                            }
                        });

                    <?php } else { ?>

                        <?php if (!empty($settings['ma_el_domain_checker_submit_button_url']['url'])) { ?>
                            var $this = $(this),
                                domain = $('.jltma-domain-name', $this).val(),
                                link_target = <?php echo (!empty($settings['ma_el_domain_checker_submit_button_url']['is_external'])) ? '"_blank"' : '""'; ?>,
                                affiliate_link = "<?php echo esc_url($settings['ma_el_domain_checker_submit_button_url']['url']); ?>?=" + domain;

                            $("<a>").prop({
                                target: link_target,
                                href: affiliate_link
                            })[0].click();
                        <?php } ?>

                    <?php } //end of Ajax Button Check
                    ?>
                });
            });
        </script>

<?php echo ob_get_clean();
    }
}

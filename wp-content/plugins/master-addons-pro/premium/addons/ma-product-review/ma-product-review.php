<?php

namespace MasterAddons\Addons;

use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Icons_Manager;
use \Elementor\Control_Icon;
use \Elementor\Controls_Manager as Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border as Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography as Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Widget_Base as Widget_Base;
use MasterAddons\Inc\Helper\Master_Addons_Helper;

/**
 * Author Name: Liton Arefin
 * Author URL : https: //jeweltheme.com
 * Date       : 3/1/22
 */

if (!defined('ABSPATH')) exit; // If this file is called directly, abort.

class JLTMA_Product_Review extends Widget_Base
{

    public function get_name()
    {
        return 'jltma-product-review';
    }

    public function get_title()
    {
        return esc_html__('Product review', 'master-addons' );
    }

    public function get_icon()
    {
        return 'jltma-icon eicon-columns';
    }

    public function get_categories()
    {
        return ['master-addons'];
    }

    public function get_script_depends()
    {
        return [
            'master-addons-waypoints',
            'master-addons-scripts',
        ];
    }

    public function get_style_depends()
    {
        return ['jltma-pro'];
    }

    public function get_help_url()
    {
        return 'https://master-addons.com/demos/product-review/';
    }

    protected function jltma_product_review_general()
    {
        $this->start_controls_section(
            'jltma_pr_review_content_section',
            [
                'label' => esc_html__('Content', 'master-addons' )
            ]
        );

        $this->add_control(
            'jltma_pr_review_title',
            [
                'label'   => esc_html__('Title', 'master-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Awesome Product', 'master-addons' ),
            ]
        );
        $this->add_control(
            'jltma_pr_review_description',
            [
                'label'   => esc_html__('Description', 'master-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __('Place here Description for your reviewbox', 'master-addons' ),
            ]
        );
        $this->add_control(
            'jltma_pr_review_score',
            [
                'label'       => esc_html__('Score Value', 'master-addons' ),
                'description' => esc_html__('By default, score is average between score criterias, but you can add own', 'master-addons' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 10,
                'min'         => 1,
                'max'         => 10,
                'step'        => 0.5,
            ]
        );
        $this->end_controls_section();
    }


    // Criteria
    protected function jltma_product_review_criteria()
    {
        $this->start_controls_section(
            'jltma_pr_review_criteria_section',
            [
                'label' => esc_html__('Criterias', 'master-addons' )
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'jltma_pr_review_criteria_title',
            [
                'label'   => esc_html__('Title', 'master-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Criteria Name', 'master-addons' ),
            ]
        );

        $repeater->add_control(
            'jltma_pr_review_criteria_num',
            [
                'label'   => esc_html__('Value', 'master-addons' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 10,
                'min'     => 1,
                'max'     => 10,
                'step'    => 0.5,
            ]
        );

        $this->add_control(
            'jltma_pr_review_criterias',
            [
                'label'       => esc_html__('Criterias', 'master-addons' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ jltma_pr_review_criteria_title }}}',
            ]
        );
        $this->end_controls_section();
    }

    // Positive
    protected function jltma_product_review_positive()
    {
        $this->start_controls_section(
            'jltma_pr_review_positive_section',
            [
                'label' => esc_html__('Positive', 'master-addons' )
            ]
        );
        $this->add_control(
            'jltma_pr_review_pros_title',
            [
                'label'   => esc_html__('Pros Title', 'master-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Positive',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'jltma_pr_review_pros_positive_title',
            [
                'label'   => esc_html__('Title', 'master-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Positive',
            ]
        );
        $this->add_control(
            'jltma_pr_review_pros',
            [
                'label'       => esc_html__('Positives', 'master-addons' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ jltma_pr_review_pros_positive_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    // Negative
    protected function jltma_product_review_negative()
    {
        $this->start_controls_section(
            'jltma_pr_review_cons_section',
            [
                'label' => esc_html__('Negative', 'master-addons' )
            ]
        );
        $this->add_control(
            'jltma_pr_review_cons_title',
            [
                'label' => esc_html__('Cons Title', 'master-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Negatives',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'jltma_pr_review_cons_repeater_title',
            [
                'label'   => esc_html__('Title', 'master-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Negative',
            ]
        );

        $this->add_control(
            'jltma_pr_review_cons',
            [
                'label'       => esc_html__('Negatives', 'master-addons' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ jltma_pr_review_cons_repeater_title }}}',
            ]
        );
        $this->end_controls_section();
    }

    // Style
    protected function jltma_product_review_style()
    {
        $this->start_controls_section(
            'jltma_pr_review_style_section',
            [
                'label' => esc_html__('Content', 'master-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'jltma_pr_review_criteria_bg_color',
                'label'     => esc_html__('Background Color', 'master-addons' ),
                'types'     => ['classic', 'gradient'],
                'exclude'   => ['image'],
                'selectors' => [
                    '{{WRAPPER}} .rate-bar-bar'              => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .review-top .overall-score' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // Register Controls
    protected function register_controls()
    {

        $this->jltma_product_review_general();
        $this->jltma_product_review_criteria();
        $this->jltma_product_review_positive();
        $this->jltma_product_review_negative();
        $this->jltma_product_review_style();

        /**
         * Content Tab: Docs Links
         */
        $this->start_controls_section(
            'jltma_section_help_docs',
            [
                'label' => esc_html__('Help Docs', 'master-addons' ),
            ]
        );


        $this->add_control(
            'jltma_help_doc_1',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(esc_html__('%1$s Live Demo %2$s', 'master-addons' ), '<a href="https://master-addons.com/demos/advanced-accordion/" target="_blank" rel="noopener">', '</a>'),
                'content_classes' => 'jltma-editor-doc-links',
            ]
        );

        $this->add_control(
            'jltma_help_doc_2',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(esc_html__('%1$s Documentation %2$s', 'master-addons' ), '<a href="https://master-addons.com/docs/addons/elementor-accordion-widget/?utm_source=widget&utm_medium=panel&utm_campaign=dashboard" target="_blank" rel="noopener">', '</a>'),
                'content_classes' => 'jltma-editor-doc-links',
            ]
        );

        $this->add_control(
            'jltma_help_doc_3',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(esc_html__('%1$s Watch Video Tutorial %2$s', 'master-addons' ), '<a href="https://www.youtube.com/watch?v=rdrqWa-tf6Q" target="_blank" rel="noopener">', '</a>'),
                'content_classes' => 'jltma-editor-doc-links',
            ]
        );
        $this->end_controls_section();



        // Upsell Notice
        if (ma_el_fs()->is_not_paying()) {

            $this->start_controls_section(
                'jltma_section_upgrade_pro',
                [
                    'label' => esc_html__('Upgrade to Pro for More Features', 'master-addons' )
                ]
            );

            $this->add_control(
                'jltma_control_get_pro',
                [
                    'label' => esc_html__('Unlock more possibilities', 'master-addons' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        '1' => [
                            'title' => esc_html__('', 'master-addons' ),
                            'icon' => 'fa fa-unlock-alt',
                        ],
                    ],
                    'default' => '1',
                    'description' => '<span class="pro-feature"> Upgrade to  <a href="' . ma_el_fs()->get_upgrade_url() . '" target="_blank">Pro Version</a> for more Elements with Customization Options.</span>'
                ]
            );

            $this->end_controls_section();

            // Style Tab Upgrade Notice
            $this->start_controls_section(
                'jltma_section_pro_style_section',
                [
                    'label' => esc_html__('Upgrade to Pro for More Features', 'master-addons' ),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );
            $this->add_control(
                'jltma_control_get_pro_style_tab',
                [
                    'label' => esc_html__('Unlock more possibilities', 'master-addons' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        '1' => [
                            'title' => esc_html__('', 'master-addons' ),
                            'icon' => 'fa fa-unlock-alt',
                        ],
                    ],
                    'default' => '1',
                    'description' => '<span class="pro-feature"> Upgrade to  <a href="' . ma_el_fs()->get_upgrade_url() . '" target="_blank">Pro Version</a> for more Elements with Customization Options.</span>'
                ]
            );
            $this->end_controls_section();
        }
    }

    /* Review Output */
    protected function render()
    {
        $settings = $this->get_settings_for_display();


        $scoretotal = 0;
        $total_counter = 0;
        $criterias = $prosblock = $consblock = '';
        if ($settings['jltma_pr_review_criterias']) {
            foreach ($settings['jltma_pr_review_criterias'] as $key => $item) {
                $criterias .= $item["jltma_pr_review_criteria_title"] . ':' . (float)$item["jltma_pr_review_criteria_num"] . ';';
            }
        }

        // if ($settings['jltma_pr_review_pros']) {
        //     foreach ($settings['jltma_pr_review_pros'] as $key => $item) {
        //         $prosblock .= $item["jltma_pr_review_pros_positive_title"] . ';';
        //     }
        // }
        // if ($prosblock) {
        //     $settings['pros'] = $prosblock;
        // }

        if ($settings['jltma_pr_review_cons']) {
            foreach ($settings['jltma_pr_review_cons'] as $key => $item) {
                $consblock .= $item["jltma_pr_review_cons_repeater_title"] . ';';
            }
        }

        if ($consblock) {
            $settings['cons'] = $consblock;
        }

        if (!empty($criterias)) {
            $thecriteria = explode(';', $criterias);
            foreach ($thecriteria as $criteria) {
                if (!empty($criteria)) {
                    $criteriaflat = explode(':', $criteria);
                    $scoretotal += $criteriaflat[1];
                    $total_counter++;
                }
            }
            if (!empty($scoretotal) && !empty($total_counter)) $total_score =  $scoretotal / $total_counter;
            $total_score = round($total_score, 1);
        }

        if (!empty($score)) {
            $total_score = $score;
        }

        $title = !empty($settings['jltma_pr_review_title']) ? $settings['jltma_pr_review_title'] : '';
        $description = !empty($settings['jltma_pr_review_description']) ? $settings['jltma_pr_review_description'] : '';

        $out = '<div class="jltma-product-review-wrap"><div class="jltma-container"><div class="review-top"><div class="overall-score">';
        $out .= '<span class="overall">' . $total_score . '</span><span class="overall-text">' . __('Expert Score', 'rehub-theme') . '</span></div>';
        $out .= '<div class="review-text"><span class="review-header">' . esc_html($title) . '</span><p>' . wp_kses_post($description) . '</p></div></div>';

        if (!empty($criterias)) {
            $out .= '<div class="review-criteria">';

            $out .= '<div class="jltma-stats-bars">';
            foreach ($thecriteria as $criteria) {
                if (!empty($criteria)) {
                    $criteriaflat = explode(':', $criteria);
                    $perc_criteria = $criteriaflat[1] * 10;
                    // $out .= '<div class="rate-bar clearfix" data-percent="' . $perc_criteria . '%">
                    // 			<div class="rate-bar-title"><span>' . $criteriaflat[0] . '</span></div>
                    // 			<div class="rate-bar-bar"></div>
                    // 			<div class="rate-bar-percent">' . $criteriaflat[1] . '</div>
                    // 		</div>';

                    // $out .= '<div ' . $this->get_render_attribute_string('jltma_rate_bar') . ' data-progress-bar>
                    //     <span class="jltma-stats-title">' . esc_attr($settings['ma_el_progress_bar_title']) . '</span>
                    // </div>';

                    $out .= '<div class="jltma-stats-bar">
                                <div class="jltma-stats-title">' . $criteriaflat[0] . '<span>' . $perc_criteria . '%</span></div>
                                <div class="jltma-stats-bar-wrap">
                                    <div style="background: #E43917; width: ' . $perc_criteria . '%;" class="jltma-stats-bar-content" data-perc="' . $perc_criteria . '"></div>
                                    <div class="jltma-stats-bar-bg"></div>
                                </div>
                            </div><!-- .jltma-stats-bar -->';
                }
            }
            $out .= '</div><!-- .jltma-stats-bars -->';
            $out .= '</div>';
        } elseif (!empty($thecriteria)) {
            $out .= '<div class="jltma-pt30 jltma-mt10">';
            foreach ($thecriteria as $criteria) {
                if (!empty($criteria)) {
                    $criteriascore = $criteria['review_post_score'];
                    $criterianame = $criteria['review_post_name'];
                    $perc_criteria = $criteriascore * 10;
                    $out .= '<div class="rate-bar clearfix" data-percent="' . $perc_criteria . '%">
								<div class="rate-bar-title"><span>' . esc_html($criterianame) . '</span></div>
								<div class="rate-bar-bar"></div>
								<div class="rate-bar-percent">' . esc_html($criteriascore) . '</div>
							</div>';
                }
            }
            $out .= '</div>';
        }


        $pros_cons_wrap = (!empty($settings['jltma_pr_review_pros']) || !empty($settings['jltma_pr_review_cons'])) ? ' class="jltma-mt20 jltma-row"' : '';
        $out .= '<div' . $pros_cons_wrap . '>';

        // Positive Block
        if (!empty($settings['jltma_pr_review_pros'])) {
            $jltma_pr_review_pros_title = (!empty($settings['jltma_pr_review_pros_title'])) ? $settings['jltma_pr_review_pros_title'] : '';

            $out .= '<div';
            if (!empty($settings['jltma_pr_review_pros']) && !empty($settings['jltma_pr_review_cons'])) {
                $out .= ' class="jltma-col-6"';
            }
            $out .= '>';
            $out .= '<div class="jltma-product-review-pros"><div class="jltma-title-pros">' . esc_html($jltma_pr_review_pros_title) . '</div><ul>';
            foreach ($settings['jltma_pr_review_pros'] as $pros_item) {
                if (!empty($pros_item)) {
                    $out .= '<li>' . esc_html($pros_item['jltma_pr_review_pros_positive_title']) . '</li>';
                }
            }
            $out .= '</ul></div></div>';
        }


        // Negative Block
        if (!empty($settings['jltma_pr_review_cons'])) {
            $jltma_pr_review_cons_title = (!empty($settings['jltma_pr_review_cons_title'])) ? $settings['jltma_pr_review_cons_title'] : '';

            $out .= '<div';
            $out .= ' class="jltma-col-6"';
            $out .= '>';
            $out .= '<div class="jltma-product-review-cons"><div class="jltma-title-cons">' . esc_html($jltma_pr_review_cons_title) . '</div><ul>';
            foreach ($settings['jltma_pr_review_cons'] as $cons_item) {
                if (!empty($cons_item)) {
                    $out .= '<li>' . esc_html($cons_item['jltma_pr_review_cons_repeater_title']) . '</li>';
                }
            }
            $out .= '</ul></div></div>';
        }
        $out .= '</div>';

        // $out .= '</div> <!-- jltma-row -->';
        $out .= '</div> <!-- jltma-container -->';
        $out .= '</div> <!-- jltma-product-review-wrap -->';

        echo wp_kses_post($out);
    }

    protected function content_template()
    {
    }
}

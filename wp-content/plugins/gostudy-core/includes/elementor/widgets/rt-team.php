<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-team.php.
 */
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class RT_Team extends Widget_Base
{
    public function get_name()
    {
        return 'rt-team';
    }

    public function get_title()
    {
        return esc_html__('Team', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-team';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Team Content', 'gostudy-core'),
            ]
        );
        $this->add_control(
            'layout_style',
            [
                'label' => __( 'Style', 'gostudy-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'   => __( 'Style 1', 'gostudy-core' ),
                    '2'   => __( 'Style 2', 'gostudy-core' ),
                ],
            ]
        );
        $this->add_control(
            'posts_column',
            [
                'label'   => __('Items Column', 'gostudy-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '12' => __('1 Column', 'gostudy-core'),
                    '6'  => __('2 Column', 'gostudy-core'),
                    '4'  => __('3 Column', 'gostudy-core'),
                    '3'  => __('4 Column', 'gostudy-core'),
                    '2'  => __('6 Column', 'gostudy-core'),
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'teacher_image',
            [
                'label'   => esc_html__('Team Image', 'gostudy-core'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'teacher_imagesize',
                'default'   => 'medium',
                'separator' => 'none',
            ]
        );
        $repeater->add_control(
            'teacher_name',
            [
                'label'       => esc_html__('Name', 'gostudy-core'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__('Jonathan Bean', 'gostudy-core'),
            ]
        );

        $repeater->add_control(
            'teacher_degree',
            [
                'label'       => esc_html__('Designation', 'gostudy-core'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__('Math Team', 'gostudy-core'),
            ]
        );

        $repeater->add_control(
            'teacher_details_link',
            [
                'label' => __('Team details page link', 'gostudy-core'),
                'type'  => Controls_Manager::URL,
            ]
        );

        $repeater->start_controls_tab('slider_content_tab', ['label' => __('Social Link', 'gostudy-core')]);

        $repeater->add_control(
            'fb_link',
            [
                'label'     => __('Facebook', 'gostudy-core'),
                'type'      => Controls_Manager::URL,
            ]
        );

        $repeater->add_control(
            'twitter_link',
            [
                'label'     => __('Twitter', 'gostudy-core'),
                'type'      => Controls_Manager::URL,

            ]
        );

        $repeater->add_control(
            'youtube_link',
            [
                'label'     => __('Youtube', 'gostudy-core'),
                'type'      => Controls_Manager::URL,
            ]
        );

        $repeater->add_control(
            'linkedin_link',
            [
                'label'     => __('Linkedin', 'gostudy-core'),
                'type'      => Controls_Manager::URL,
            ]
        );

        $repeater->add_control(
            'instagram_link',
            [
                'label'     => __('Instagram', 'gostudy-core'),
                'type'      => Controls_Manager::URL,
            ]
        );

        $repeater->add_control(
            'skype_link',
            [
                'label'     => __('Skype', 'gostudy-core'),
                'type'      => Controls_Manager::URL,
                'condition' => [
                    'teacher_social_link' => 'skype',
                ],

            ]
        );

        $repeater->add_control(
            'whatsapp_link',
            [
                'label'     => __('Whatsapp', 'gostudy-core'),
                'type'      => Controls_Manager::URL,

            ]
        );
        $repeater->add_control(
            'snapchat_link',
            [
                'label'     => __('Snapchat', 'gostudy-core'),
                'type'      => Controls_Manager::URL,
            ]
        );
        $repeater->add_control(
            'github_link',
            [
                'label'     => __('Github', 'gostudy-core'),
                'type'      => Controls_Manager::URL,
            ]
        );
        $repeater->add_control(
            'gitlab_link',
            [
                'label'     => __('Gitlab', 'gostudy-core'),
                'type'      => Controls_Manager::URL,
            ]
        );

        $repeater->end_controls_tab();

        $this->add_control(
            'teacher_options',
            [
                'label'       => esc_html__('Add Team', 'gostudy-core'),
                'type'        => Controls_Manager::REPEATER,
                'show_label'  => true,
                'default'     => [
                    [
                        'teacher_image'  => '',
                        'teacher_name'   => esc_html__('Team 1', 'gostudy-core'),
                        'teacher_degree' => esc_html__('Degree 1', 'gostudy-core'),
                    ],
                    [
                        'teacher_image'  => '',
                        'teacher_name'   => esc_html__('Team 2', 'gostudy-core'),
                        'teacher_degree' => esc_html__('Degree 2', 'gostudy-core'),
                    ],
                    [
                        'teacher_image'  => '',
                        'teacher_name'   => esc_html__('Team 3', 'gostudy-core'),
                        'teacher_degree' => esc_html__('Degree 3', 'gostudy-core'),
                    ],
                    [
                        'teacher_image'  => '',
                        'teacher_name'   => esc_html__('Team 4', 'gostudy-core'),
                        'teacher_degree' => esc_html__('Degree 4', 'gostudy-core'),
                    ],
                ],
                'fields'  => $repeater->get_controls(),
                'title_field' => '{{{teacher_name}}}',
            ]
        );

        $this->add_control(
            'name_tag',
            [
                'label' => __( 'Name Tag', 'gostudy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'degree_tag',
            [
                'label' => __( 'Degree Tag', 'gostudy-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'p',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_styles',
            [
                'label' => esc_html__('Styles', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_fixed_height',
            [
                'label'     => __('Image Height', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 80,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gostudy-teacher-wrapper .teacher-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'base_color_1',
            [
                'label'     => __('Base Color 1', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-clm:nth-child(3n+1) .gostudy-teacher-wrapper .teacher-bottom' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .gostudy-clm:nth-child(3n+1) .gostudy-teacher-wrapper a.team-icon'     => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'base_color_2',
            [
                'label'     => __('Base Color 2', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-clm:nth-child(3n+2) .gostudy-teacher-wrapper .teacher-bottom' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .gostudy-clm:nth-child(3n+2) .gostudy-teacher-wrapper a.team-icon'     => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'base_color_3',
            [
                'label'     => __('Base Color 3', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-clm:nth-child(3n+3) .gostudy-teacher-wrapper .teacher-bottom' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .gostudy-clm:nth-child(3n+3) .gostudy-teacher-wrapper a.team-icon'     => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'teacher_button_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .gostudy-teacher-wrapper .teacher-bottom' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );
        $this->add_responsive_control(
            'teacher_button_bg_color',
            [
                'label'     => __('Button Background', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-teacher-wrapper .teacher-bottom' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // Star style tab
        $this->start_controls_section(
            'teacher_name_style',
            [
                'label' => esc_html__('Name', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_title_style');

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __('Normal', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-teacher-wrapper .teacher-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => __('Hover', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => __('Title Hover Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-teacher-wrapper a:hover .teacher-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .gostudy-teacher-wrapper .teacher-name',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'teacher_degree_style',
            [
                'label' => esc_html__('Degree', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'digree_color',
            [
                'label'     => __('Degree', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-teacher-wrapper .teacher-deg' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'digree_typography',
                'selector' => '{{WRAPPER}} .gostudy-teacher-wrapper .teacher-deg',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'teacher_social_style',
            [
                'label' => esc_html__('Social', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => __('Icon', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-teacher-wrapper .social-shear .team-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label'     => __('Icon Hover', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-teacher-wrapper .social-shear a.team-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }
    protected function render($instance = [])
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('teacher_area_attr', 'class', 'gostudy-teacher');
        $this->add_render_attribute('teacher_row', 'class', 'row');
        $this->add_render_attribute('gostudy_posts_column', 'class', 'gostudy-clm col-sm-6 col-lg-' . $settings['posts_column']);

        ?>
    <div class="gostudy-teacher-layout layout-<?php echo $settings['layout_style']; ?>">
        <div <?php echo $this->get_render_attribute_string('teacher_row'); ?> >

            <?php foreach ($settings['teacher_options'] as $teacher_option): ?>

                <div <?php echo $this->get_render_attribute_string('gostudy_posts_column'); ?> >
                    <div class="gostudy-teacher-wrapper">
                        <div class="teacher-img">
                            <?php if ($teacher_option['teacher_details_link']['url']): ?>
                                <a href="<?php echo $teacher_option['teacher_details_link']['url'] ?>">
                            <?php endif;?>
                                <?php
                                echo '<div class="teacher-image">' . Group_Control_Image_Size::get_attachment_image_html($teacher_option, 'teacher_imagesize', 'teacher_image') . '</div>';
                                ?>
                            <?php if ($teacher_option['teacher_details_link']['url']): ?>
                            </a>
                            <?php endif;?>
                        </div>
                        <div class="teacher-bottom">
                            <div class="teacher-name-deg">

                                <?php if ($teacher_option['teacher_details_link']['url']): ?>
                                    <a href="<?php echo $teacher_option['teacher_details_link']['url'] ?>">
                                <?php endif;?>
                                    <<?php echo esc_attr( $settings['name_tag'] ); ?> class="teacher-name"><?php echo $teacher_option['teacher_name']; ?></<?php echo esc_attr( $settings['name_tag'] ); ?>>
                                <?php if ($teacher_option['teacher_details_link']['url']): ?>
                                    </a>
                                <?php endif;?>

                                <?php if ($teacher_option['teacher_degree']): ?>
                                    <<?php echo esc_attr( $settings['degree_tag'] ); ?> class="teacher-deg"><?php echo $teacher_option['teacher_degree']; ?></<?php echo esc_attr( $settings['degree_tag'] ); ?>>
                                <?php endif;?>

                            </div>
                            <div class="social-shear">
                                <span class="team-icon fa fa-share-alt"></span>

                            <?php if ($teacher_option['fb_link']['url'] || $teacher_option['twitter_link']['url'] || $teacher_option['gitlab_link']['url'] || $teacher_option['github_link']['url'] || $teacher_option['linkedin_link']['url'] || $teacher_option['whatsapp_link']['url'] || $teacher_option['snapchat_link']['url'] || $teacher_option['instagram_link']['url'] || $teacher_option['skype_link']['url']): ?>
                                <div class="team-info-icons">

                                <?php if ($teacher_option['fb_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['fb_link']['url']); ?>" <?php if ($teacher_option['fb_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-facebook">
                                    </a>
                                 <?php endif;?>
                                <?php if ($teacher_option['twitter_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['twitter_link']['url']); ?>" <?php if ($teacher_option['twitter_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-twitter">
                                    </a>
                                 <?php endif;?>
                                <?php if ($teacher_option['youtube_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['youtube_link']['url']); ?>" <?php if ($teacher_option['youtube_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-youtube">
                                    </a>
                                 <?php endif;?>
                                <?php if ($teacher_option['linkedin_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['linkedin_link']['url']); ?>" <?php if ($teacher_option['linkedin_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-linkedin">
                                    </a>
                                 <?php endif;?>
                                <?php if ($teacher_option['instagram_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['instagram_link']['url']); ?>" <?php if ($teacher_option['instagram_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-instagram">
                                    </a>
                                 <?php endif;?>
                                <?php if ($teacher_option['skype_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['skype_link']['url']); ?>" <?php if ($teacher_option['skype_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-skype">
                                    </a>
                                 <?php endif;?>
                                <?php if ($teacher_option['whatsapp_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['whatsapp_link']['url']); ?>" <?php if ($teacher_option['whatsapp_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-whatsapp">
                                    </a>
                                 <?php endif?>
                                <?php if ($teacher_option['snapchat_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['snapchat_link']['url']); ?>" <?php if ($teacher_option['snapchat_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-snapchat-ghost">
                                    </a>
                                 <?php endif;?>
                                <?php if ($teacher_option['github_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['github_link']['url']); ?>" <?php if ($teacher_option['github_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-github">
                                    </a>
                                 <?php endif;?>
                                <?php if ($teacher_option['gitlab_link']['url']): ?>
                                    <a href="<?php echo esc_url($teacher_option['gitlab_link']['url']); ?>" <?php if ($teacher_option['gitlab_link']['is_external']): echo 'target="_blank"';endif;?> class="team-icon fab fa-gitlab">
                                    </a>
                                 <?php endif;?>

                                </div>
                            <?php endif;?>

                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach;?>

        </div>
    </div>
<?php
}
}

<?php

namespace MasterAddons\Addons;

if (!defined('ABSPATH')) exit; // If this file is called directly, abort.

use \Elementor\Utils;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;
use MasterAddons\Inc\Helper\Master_Addons_Helper;

class JLTMA_Source_Code extends Widget_Base
{

    public function get_name()
    {
        return 'jltma-source-code';
    }

    public function get_title()
    {
        return esc_html__('Source Code', 'master-addons' );
    }

    public function get_icon()
    {
        return 'jltma-icon eicon-code';
    }

    public function get_categories()
    {
        return ['master-addons'];
    }

    public function get_script_depends()
    {
        return ['jltma-prism'];
    }

    public function get_style_depends()
    {
        return ['jltma-pro'];
    }

    protected function register_controls()
    {
        $this->jltma_source_code_general_section();
        $this->jltma_source_code_container_style_section();
        $this->jltma_source_code_button_style_section();
    }

    protected function jltma_source_code_button_style_section()
    {

        $this->start_controls_section(
            'jltma_source_code_button_style',
            [
                'label'     => esc_html__('Button', 'master-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'jltma_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'             => 'jltma_source_code_button_text_typography',
                'fields_options'   => [
                    'font_size'    => [
                        'default'  => [
                            'unit' => 'px',
                            'size' => 13
                        ]
                    ]
                ],
                'selector'         => '{{WRAPPER}} .jltma-source-code pre .jltma-copy-button'
            ]
        );

        $this->add_control(
            'jltma_source_code_button_color',
            [
                'label'     => esc_html__('Text Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .jltma-source-code pre .jltma-copy-button' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'jltma_source_code_button_bg_color',
            [
                'label'     => esc_html__('Background Color', 'master-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#643df3',
                'selectors' => [
                    '{{WRAPPER}} .jltma-source-code pre .jltma-copy-button' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'jltma_source_code_button_padding',
            [
                'label'        => __('Padding', 'master-addons' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '6',
                    'right'    => '25',
                    'bottom'   => '6',
                    'left'     => '25',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .jltma-source-code pre .jltma-copy-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'jltma_source_code_button_border',
                'selector' => '{{WRAPPER}} .jltma-source-code pre .jltma-copy-button'
            ]
        );

        $this->add_responsive_control(
            'jltma_source_code_button_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'master-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => '0',
                    'right'  => '15',
                    'bottom' => '0',
                    'left'   => '15'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .jltma-source-code pre .jltma-copy-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function jltma_source_code_general_section()
    {
        $this->start_controls_section(
            'jltma_source_code_control_section',
            [
                'label' => __('Source Code', 'master-addons' )
            ]
        );

        $this->add_control(
            'jltma_source_code_type',
            [
                'label' => __('Code', 'master-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'markup',
                'options' => $this->jltma_get_source_code_type()
            ]
        );

        $this->add_control(
            'jltma_source_code_theme',
            [
                'label' => __('Theme', 'master-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'prism',
                'options' => [
                    'prism' => __('Default', 'master-addons' ),
                    'prism-dark' => __('Dark', 'master-addons' ),
                    'prism-funky' => __('Funky', 'master-addons' ),
                    'prism-okaidia' => __('Okaidia', 'master-addons' ),
                    'prism-twilight' => __('Twilight', 'master-addons' ),
                    'prism-coy' => __('Coy', 'master-addons' ),
                    'prism-solarizedlight' => __('Solarized light', 'master-addons' ),
                    'prism-tomorrow' => __('Tomorrow', 'master-addons' ),
                    'custom' => __('Custom', 'master-addons' )
                ]
            ]
        );

        $this->add_control(
            'jltma_source_code',
            [
                'label' => __('Source Code', 'master-addons' ),
                'type' => Controls_Manager::CODE,
                'rows' => 30,
                'default' => __('<p class="your-class-here">Master Addons For Elementor Source Code example here.</p>'),
                'placeholder' => __('Paste your source code here.', 'master-addons' )
            ]
        );

        $this->add_control(
            'jltma_source_code_enable_copy_button',
            [
                'label' => esc_html__('Enable Copy Button', 'master-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'jltma_source_code_enable_line_number',
            [
                'label' => esc_html__('Enable Line Number', 'master-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'jltma_source_code_button_visibility_type',
            [
                'label' => esc_html__('Button Visibility', 'master-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'always',
                'options' => [
                    'always' => esc_html__('Always', 'master-addons' ),
                    'on-hover' => esc_html__('On Hover', 'master-addons' )
                ],
                'condition' => [
                    'jltma_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'jltma_source_code_button_position_type',
            [
                'label' => esc_html__('Button Position', 'master-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'top-right',
                'options' => [
                    'top-right' => esc_html__('Top Right Corner', 'master-addons' ),
                    'bottom-right' => esc_html__('Bottom Right Corner', 'master-addons' )
                ],
                'condition' => [
                    'jltma_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'jltma_source_code_copy_btn_text',
            [
                'label' => esc_html__('Copy Button Text', 'master-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Copy to clipboard', 'master-addons' ),
                'condition' => [
                    'jltma_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'jltma_source_code_after_copied_btn_text',
            [
                'label' => esc_html__('After Copied Button Text', 'master-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Copied', 'master-addons' ),
                'condition' => [
                    'jltma_source_code_enable_copy_button' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function jltma_source_code_container_style_section()
    {

        $this->start_controls_section(
            'jltma_source_code_container_style',
            [
                'label' => esc_html__('Container', 'master-addons' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'jltma_source_code_container_height',
            [
                'label' => __('Height', 'master-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => apply_filters('jltma_source_code_container_height_max_value', 1200),
                        'step' => 5
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .jltma-source-code pre' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'jltma_source_code_container_background_color',
                'label' => __('Background', 'master-addons' ),
                'types' => ['classic', 'gradient'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#f5f2f0'
                    ]
                ],
                'selector' => '{{WRAPPER}} .custom :not(pre) > code[class*="language-"], {{WRAPPER}} .custom pre[class*="language-"]',
                'condition' => [
                    'jltma_source_code_theme' => 'custom'
                ]
            ]
        );

        $this->add_responsive_control(
            'jltma_source_code_container_padding',
            [
                'label' => __('Padding', 'master-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '10',
                    'right' => '20',
                    'bottom' => '10',
                    'left' => '80'
                ],
                'selectors' => [
                    '{{WRAPPER}} .jltma-source-code pre' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'jltma_source_code_container_margin',
            [
                'label' => __('Margin', 'master-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .jltma-source-code pre' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'jltma_source_code_container_typography',
                'label' => __('Typography', 'master-addons' ),
                'selector' => '{{WRAPPER}} .custom :not(pre) > code[class*="language-"], {{WRAPPER}} .custom pre[class*="language-"] .language-markup',
                'condition' => [
                    'jltma_source_code_theme' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'jltma_source_code_container_text_color',
            [
                'label' => __('Text Color', 'master-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom :not(pre) > code[class*="language-"], {{WRAPPER}} .custom pre[class*="language-"] .language-markup' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'jltma_source_code_theme' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'jltma_source_code_container_line_number_color',
            [
                'label' => __('Line Number Color', 'master-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .jltma-source-code .line-numbers-rows > span:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .jltma-source-code .line-numbers .line-numbers-rows' => 'border-right: 1px solid {{VALUE}};',
                ],
                'condition' => [
                    'jltma_source_code_theme' => 'custom'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'jltma_source_code_container_border',
                'selector' => '{{WRAPPER}} .jltma-source-code pre'
            ]
        );

        $this->add_responsive_control(
            'jltma_source_code_container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'master-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0'
                ],
                'selectors' => [
                    '{{WRAPPER}} .jltma-source-code pre' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }


    protected function jltma_get_source_code_type()
    {
        return [
            'markup'            => __('HTML', 'master-addons' ),
            'css'               => __('CSS', 'master-addons' ),
            'php'               => __('PHP', 'master-addons' ),
            'javascript'        => __('JavaScript', 'master-addons' ),
            'actionscript'      => __('ActionScript', 'master-addons' ),
            'apacheconf'        => __('Apache Configuration', 'master-addons' ),
            'applescript'       => __('AppleScript', 'master-addons' ),
            'arduino'           => __('Arduino', 'master-addons' ),
            'aspnet'            => __('ASP.NET(C#)', 'master-addons' ),
            'bash'              => __('Bash', 'master-addons' ),
            'basic'             => __('BASIC', 'master-addons' ),
            'c'                 => __('C', 'master-addons' ),
            'csharp'            => __('C#', 'master-addons' ),
            'cpp'               => __('C++', 'master-addons' ),
            'clike'             => __('Clike', 'master-addons' ),
            'clojure'           => __('Clojure', 'master-addons' ),
            'coffeescript'      => __('CoffeeScript', 'master-addons' ),
            'dart'              => __('Dart', 'master-addons' ),
            'django'            => __('Django/Jinja2', 'master-addons' ),
            'docker'            => __('Docker', 'master-addons' ),
            'elixir'            => __('Elixir', 'master-addons' ),
            'erlang'            => __('Erlang', 'master-addons' ),
            'git'               => __('Git', 'master-addons' ),
            'go'                => __('Go', 'master-addons' ),
            'graphql'           => __('GraphQL', 'master-addons' ),
            'haml'              => __('Haml', 'master-addons' ),
            'haskell'           => __('Haskell', 'master-addons' ),
            'http'              => __('HTTP', 'master-addons' ),
            'hpkp'              => __('HTTP Public-Key-Pins', 'master-addons' ),
            'hsts'              => __('HTTP Strict-Transport-Security', 'master-addons' ),
            'java'              => __('Java', 'master-addons' ),
            'javadoc'           => __('JavaDoc', 'master-addons' ),
            'javadoclike'       => __('JavaDoc-like', 'master-addons' ),
            'javastacktrace'    => __('Java stack trace', 'master-addons' ),
            'jsdoc'             => __('JSDoc', 'master-addons' ),
            'js-extras'         => __('JS Extras', 'master-addons' ),
            'js-templates'      => __('JS Templates', 'master-addons' ),
            'json'              => __('JSON', 'master-addons' ),
            'jsonp'             => __('JSONP', 'master-addons' ),
            'json5'             => __('JSON5', 'master-addons' ),
            'kotlin'            => __('Kotlin', 'master-addons' ),
            'less'              => __('Less', 'master-addons' ),
            'lisp'              => __('Lisp', 'master-addons' ),
            'markdown'          => __('Markdown', 'master-addons' ),
            'markup-templating' => __('Markup templating', 'master-addons' ),
            'matlab'            => __('MATLAB', 'master-addons' ),
            'nginx'             => __('nginx', 'master-addons' ),
            'nix'               => __('Nix', 'master-addons' ),
            'objectivec'        => __('Objective-C', 'master-addons' ),
            'perl'              => __('Perl', 'master-addons' ),
            'phpdoc'            => __('PHPDoc', 'master-addons' ),
            'php-extras'        => __('PHP Extras', 'master-addons' ),
            'plsql'             => __('PL/SQL', 'master-addons' ),
            'powershell'        => __('PowerShell', 'master-addons' ),
            'python'            => __('Python', 'master-addons' ),
            'r'                 => __('R', 'master-addons' ),
            'jsx'               => __('React JSX', 'master-addons' ),
            'tsx'               => __('React TSX', 'master-addons' ),
            'regex'             => __('Regex', 'master-addons' ),
            'rest'              => __('reST (reStructuredText)', 'master-addons' ),
            'ruby'              => __('Ruby', 'master-addons' ),
            'sass'              => __('Sass (Sass)', 'master-addons' ),
            'scss'              => __('Sass (Scss)', 'master-addons' ),
            'scala'             => __('Scala', 'master-addons' ),
            'sql'               => __('SQL', 'master-addons' ),
            'stylus'            => __('Stylus', 'master-addons' ),
            'swift'             => __('Swift', 'master-addons' ),
            'twig'              => __('Twig', 'master-addons' ),
            'typescript'        => __('TypeScript', 'master-addons' ),
            'vbnet'             => __('VB.Net', 'master-addons' ),
            'visual-basic'      => __('Visual Basic', 'master-addons' ),
            'wasm'              => __('WebAssembly', 'master-addons' ),
            'wiki'              => __('Wiki markup', 'master-addons' ),
            'xquery'            => __('XQuery', 'master-addons' ),
            'yaml'              => __('YAML', 'master-addons' )
        ];
    }

    protected function render()
    {
        $settings         = $this->get_settings_for_display();
        $jltma_source_code = $settings['jltma_source_code'];
        $line_number = 'disable-line-numbers';

        if ('yes' === $settings['jltma_source_code_enable_line_number']) :
            $line_number = 'line-numbers';
        endif;

        $this->add_render_attribute('jltma_source_code_wrapper', 'class', 'jltma-source-code');
        $this->add_render_attribute('jltma_source_code_wrapper', 'class', esc_attr($settings['jltma_source_code_theme']));
        $this->add_render_attribute('jltma_source_code_wrapper', 'data-lng-type', esc_attr($settings['jltma_source_code_type']));

        if ('yes' === $settings['jltma_source_code_enable_copy_button'] && !empty($settings['jltma_source_code_after_copied_btn_text'])) :
            $this->add_render_attribute('jltma_source_code_wrapper', 'data-after-copied-btn-text', esc_attr($settings['jltma_source_code_after_copied_btn_text']));
            $this->add_render_attribute('jltma_source_code_wrapper', 'class', 'visibility-' . esc_attr($settings['jltma_source_code_button_visibility_type']));
            $this->add_render_attribute('jltma_source_code_wrapper', 'class', 'position-' . esc_attr($settings['jltma_source_code_button_position_type']));
        endif;

        $this->add_render_attribute('jltma_source_code', 'class', 'language-' . esc_attr($settings['jltma_source_code_type']));

        if ($jltma_source_code) : ?>
            <div <?php $this->print_render_attribute_string('jltma_source_code_wrapper'); ?>>
                <pre class="<?php echo esc_attr($line_number); ?>">
                    <?php
                    if ('yes' === $settings['jltma_source_code_enable_copy_button'] && !empty($settings['jltma_source_code_after_copied_btn_text'])) : ?>
                        <button class="jltma-copy-button"><?php echo esc_html($settings['jltma_source_code_copy_btn_text']); ?></button>
                    <?php endif; ?>
                    <code <?php $this->print_render_attribute_string('jltma_source_code'); ?>>
                        <?php echo esc_html($jltma_source_code); ?>
                    </code>
                </pre>
            </div>
<?php
        endif;
    }
}

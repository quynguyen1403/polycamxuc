<?php

define('RT_ELEMENTOR_ADDONS_URL', plugins_url('/', __FILE__));
define('RT_ELEMENTOR_ADDONS_PATH', plugin_dir_path(__FILE__));
define('RT_ELEMENTOR_ADDONS_FILE', __FILE__);

use Elementor\{
    Plugin,
    Core\Base\Document,
    Core\Schemes\Manager as Schemes_Manager
};
use RTAddons\Includes\RT_Elementor_Helper;
use Gostudy_Theme_Helper as Gostudy;

if (!class_exists('RT_Addons_Elementor')) {
    /**
     * RT Elementor Extenstion
     *
     *
     * @package gostudy-core\includes\elementor
     * @author RaisTheme <help.raistheme@gmail.com>
     * @since 1.0.0
     */
    class RT_Addons_Elementor
    {
        /**
         * RT Addons elementor dir path
         *
         * @since 1.0.0
         *
         * @var string The defualt path to elementor dir on this plugin.
         */
        private $dir_path;

        private static $instance = null;

        public function __construct()
        {
            $this->dir_path = plugin_dir_path(__FILE__);

            add_action('plugins_loaded', [$this, 'elementor_setup']);

            add_action('elementor/init', [$this, 'optimize_elementor'], 5);
            add_action('elementor/init', [$this, 'elementor_init']);
            add_action('elementor/init', [$this, 'elementor_header_builder']);
            add_action('elementor/init', [$this, 'save_custom_schemes']);
            add_action('elementor/init', [$this, '_v_3_0_0_compatible']);

            add_filter('elementor/widgets/wordpress/widget_args', [$this, 'rt_widget_args'], 10, 1); // WPCS: spelling ok.

            add_filter('admin_bar_menu', [$this, 'replace_elementor_admin_bar_title'], 400);
            add_action('elementor/css-file/post/enqueue', [$this, 'add_document_to_admin_bar']);
            add_action('wp_before_admin_bar_render', [$this, 'remove_admin_bar_node']);
            add_action('wp_enqueue_scripts', [$this, 'admin_bar_style']);

            add_action('elementor/frontend/get_builder_content', [$this, 'add_builder_to_admin_bar'], 10, 2);
            add_filter('elementor/frontend/admin_bar/settings', [$this, 'add_menu_in_admin_bar']);

            add_filter('template_include', [$this, 'modify_page_structure_for_saved_templates'], 12); // after Elementors hook
        }

        /**
         * Eliminate redundant functionality
         * and speed up website load
         */
        public function optimize_elementor()
        {
            if (!class_exists('\Gostudy_Theme_Helper')) {
                return;
            }

            if (Gostudy::get_option('disable_elementor_googlefonts')) {
                /**
                 * Disable Google Fonts
                 * Note: breaks all fonts selected within `Group_Control_Typography` (if any).
                 */
                add_filter('elementor/frontend/print_google_fonts', '__return_false');
            }

            if (Gostudy::get_option('disable_elementor_fontawesome')) {
                /** Disable Font Awesome pack */
                add_action('elementor/frontend/after_register_styles', function () {
                    foreach (['solid', 'regular', 'brands'] as $style) {
                        wp_deregister_style('elementor-icons-fa-' . $style);
                    }
                }, 20);
            }
        }

        /**
         * Installs default variables and checks if Elementor is installed
         *
         * @return void
         */
        public function elementor_setup()
        {
            /**
             * Check if Elementor installed and activated
             * @see https://developers.elementor.com/creating-an-extension-for-elementor/
             */
            if (!did_action('elementor/loaded')) {
                return;
            }

            // Include Modules files
            $this->includes();

            $this->init_addons();
        }

        /**
         * Load required core files.
         */
        public function includes()
        {
            $this->init_helper_files();
        }

        /**
         * Require initial necessary files
         */
        public function init_helper_files()
        {
            require_once $this->dir_path . 'includes/loop_settings.php';
            require_once $this->dir_path . 'includes/icons_settings.php';
            require_once $this->dir_path . 'includes/slider_settings.php';
            require_once $this->dir_path . 'includes/carousel_settings.php';
            require_once $this->dir_path . 'includes/feedback_settings.php';
            require_once $this->dir_path . 'includes/plugin_helper.php';

            $this->templates_register();
        }

        /**
         * Require initial necessary files
         */
        public function init_modules_files()
        {
            foreach (glob($this->dir_path . 'modules/' . '*.php') as $file) {
                $this->register_modules_addon($file);
            }
        }

        /**
         * Register addon by file name
         *
         * @access public
         * @since 1.0.0
         *
         * @param  string $file            File name.
         * @return void
         */
        public function register_modules_addon($file)
        {
            $base = basename(str_replace('.php', '', $file));
            $class = ucwords(str_replace('-', ' ', $base));
            $class = str_replace(' ', '_', $class);
            $class = sprintf('RTAddons\Modules\%s', $class);

            // Class File
            require_once $file;

            if (class_exists($class)) {
                new $class();
            }
        }

        /**
         * Load required file for addons integration
         */
        public function init_addons()
        {
            add_action('elementor/widgets/widgets_registered', [$this, 'widgets_area']);
            add_action('elementor/controls/controls_registered', [$this, 'controls_area']);

            // Register Frontend Widget Scripts
            add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

            // Register Backend Widget Scripts
            add_action('elementor/editor/before_enqueue_scripts', [$this, 'extensions_scripts']);

            $this->init_modules_files();
        }

        /**
         * Load controls require function
         */
        public function controls_area()
        {
            $this->controls_register();
        }

        /**
         * Requires controls files
         */
        private function controls_register()
        {
            foreach (glob($this->dir_path . 'controls/' . '*.php') as $file) {
                $this->register_controls_addon($file);
            }
        }

        /**
         * Register addon by file name.
         *
         * @access public
         * @since 1.0.0
         *
         * @param  string $file            File name.
         * @return void
         */
        public function register_controls_addon($file)
        {
            $controls_manager = Plugin::$instance->controls_manager;

            $base = basename(str_replace('.php', '', $file));
            $class = ucwords(str_replace('-', ' ', $base));
            $class = str_replace(' ', '_', $class);
            $class = sprintf('RTAddons\Controls\%s', $class);

            // Class Constructor File
            require_once $file;

            if (class_exists($class)) {
                $name_class = new $class();
                $controls_manager->register_control($name_class->get_type(), new $class);
            }
        }

        /**
         * Load widgets require function
         */
        public function widgets_area()
        {
            $this->widgets_register();
            $this->widgets_header();
        }

        /**
         * Requires templates files
         */
        private function templates_register()
        {
            $template_names = [];
            $template_path = '/gostudy-core/elementor/templates/';
            $plugin_template_path = $this->dir_path . 'templates/';

            foreach (glob($plugin_template_path . '*.php') as $file) {
                $template_name = basename($file);
                array_push($template_names, $template_name);
            }

            $files = RT_Elementor_Helper::get_locate_template($template_names, '/templates/', $template_path);

            foreach ((array) $files as $file) {
                require_once $file;
            }
        }

        /**
         * Requires widgets files
         */
        private function widgets_register()
        {
            $template_names = [];
            $template_path = '/gostudy-core/elementor/widgets/';
            $plugin_template_path = $this->dir_path . 'widgets/';

            foreach (glob($plugin_template_path . '*.php') as $file) {
                $template_name = basename($file);
                array_push($template_names, $template_name);
            }

            $files = RT_Elementor_Helper::get_locate_template($template_names, '/widgets/', $template_path);

            foreach ((array) $files as $file) {
                $this->register_widgets_addon($file);
            }
        }

        /**
         * Requires widgets files
         */
        private function widgets_header()
        {
            foreach (glob($this->dir_path . 'header/' . '*.php') as $file) {
                $this->register_widgets_addon($file);
            }
        }

        private function header_module_check($class)
        {
            if ($class === 'RTAddons\Widgets\RT_Header_Cart' && !class_exists('\WooCommerce')) {
                return false;
            }
            if ($class === 'RTAddons\Widgets\RT_Header_Wc_login' && !class_exists('\WooCommerce')) {
                return false;
            }
            if ($class === 'RTAddons\Widgets\RT_Header_Lp_login' && !class_exists('\LearnPress')) {
                return false;
            }
            if ($class === 'RTAddons\Widgets\RT_Header_Wpml' && !class_exists('\SitePress')) {
                return false;
            }

            return true;
        }

        /**
         * Register widgets by file name
         */
        public function register_widgets_addon($file)
        {
            $widget_manager = Plugin::instance()->widgets_manager;

            $base  = basename(str_replace('.php', '', $file));
            $class = ucwords(str_replace('-', ' ', $base));
            $class = str_replace(' ', '_', $class);
            $class = sprintf('RTAddons\Widgets\%s', $class);

            $module_header = $this->header_module_check($class);

            if (!(bool) $module_header) {
                return;
            }

            if ($class === 'RTAddons\Widgets\RT_Blog_Hero') {
                return;
            }

            if (($class === 'RTAddons\Widgets\RT_Courses' || $class === 'RTAddons\Widgets\RT_Courses_Alt') && !class_exists('LearnPress')) {
                return;
            }

            // Class File
            require_once $file;

            if (class_exists($class)) {
                $widget_manager->register_widget_type(new $class);
            }
        }

        /**
         * Enqueue all the widgets scripts.
         *
         *
         * @access public
         * @since 1.0.0
         */
        public function widget_scripts()
        {
            wp_register_script(
                'rt-elementor-extensions-widgets',
                RT_ELEMENTOR_ADDONS_URL . '/assets/js/rt_elementor_widgets.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'isotope',
                RT_ELEMENTOR_ADDONS_URL . 'assets/js/isotope.pkgd.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'jquery-appear',
                get_template_directory_uri() . '/js/jquery.appear.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'slick',
                get_template_directory_uri() . '/js/slick.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            // wp_register_script(
            //     'swiper',
            //     get_template_directory_uri() . '/js/swiper.js',
            //     ['jquery'],
            //     '1.0.0',
            //     true
            // );

            wp_register_script(
                'jarallax',
                get_template_directory_uri() . '/js/jarallax.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'jarallax-video',
                get_template_directory_uri() . '/js/jarallax-video.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'jquery-countdown',
                get_template_directory_uri() . '/js/jquery.countdown.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'cocoen',
                get_template_directory_uri() . '/js/cocoen.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'perfect-scrollbar',
                get_template_directory_uri() . '/js/perfect-scrollbar.min.js',
                ['jquery'],
                '1.0.0',
                true
            );

            wp_register_script(
                'jquery-justifiedGallery',
                get_template_directory_uri() . '/js/jquery.justifiedGallery.min.js',
                ['jquery'],
                '1.0.0',
                true
            );
        }

        /**
         * Elementor Init
         *
         *
         * @access public
         * @since 1.0.0
         * @return void
         */
        public function elementor_init()
        {
            Plugin::instance()->elements_manager->add_category(
                'rt-extensions',
                ['title' => esc_html__('RT Extensions', 'gostudy-core')],
                1
            );
        }

        /**
         * Header Builder
         *
         *
         * @access public
         * @since 1.0.0
         * @return void
         */
        public function elementor_header_builder()
        {
            Plugin::instance()->elements_manager->add_category(
                'rt-header-modules',
                ['title' => esc_html__('RT Header Modules', 'gostudy-core')],
                1
            );
        }

        public function extensions_scripts()
        {
            wp_enqueue_style('gostudy-flaticon', get_template_directory_uri() . '/fonts/flaticon/flaticon.css');
        }

        public function save_custom_schemes()
        {
            if (!class_exists('\Gostudy_Theme_Helper')) {
                return;
            }

            $schemes_manager = new Schemes_Manager();

            $header_font = Gostudy::get_option('header-font');
            $main_font = Gostudy::get_option('main-font');

            $page_colors_switch = Gostudy::get_mb_option('page_colors_switch', 'mb_page_colors_switch', 'custom');
            // $use_gradient_switch = Gostudy::get_mb_option('use-gradient', 'mb_page_colors_switch', 'custom');

            if ($page_colors_switch == 'custom') {
                $theme_color = Gostudy::get_mb_option('page_theme_color', 'mb_page_colors_switch', 'custom');
            } else {
                $theme_color = Gostudy::get_option('theme-primary-color');
            }

            $theme_fonts = [
                '1' => [
                    'font_family' => esc_attr($header_font['font-family']),
                    'font_weight' => esc_attr($header_font['font-weight']),
                ],
                '2' => [
                    'font_family' => esc_attr($header_font['font-family']),
                    'font_weight' => '400',
                ],
                '3' => [
                    'font_family' => esc_attr($main_font['font-family']),
                    'font_weight' => esc_attr($main_font['font-weight']),
                ],
                '4' => [
                    'font_family' => esc_attr($main_font['font-family']),
                    'font_weight' => '400',
                ],
            ];

            $scheme_obj_typo = $schemes_manager->get_scheme('typography');

            $theme_color = [
                '1' => esc_attr($theme_color),
                '2' => esc_attr($header_font['color']),
                '3' => esc_attr($main_font['color']),
                '4' => esc_attr($theme_color),
            ];

            $scheme_obj_color = $schemes_manager->get_scheme('color');

            // Save Options
            $scheme_obj_typo->save_scheme($theme_fonts);
            $scheme_obj_color->save_scheme($theme_color);
        }

        public function rt_widget_args($params)
        {
            // Default wrapper for widget and title
            $id = str_replace('wp-', '', $params['widget_id']);
            $id = str_replace('-', '_', $id);

            $wrapper_before = '<div class="rt-elementor-widget widget gostudy_widget ' . esc_attr($id) . '">';
            $wrapper_after = '</div>';
            $title_before = '<div class="title-wrapper"><span class="title">';
            $title_after = '</span></div>';

            $default_widget_args = [
                'id' => 'sidebar_' . esc_attr(strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $params['widget_id'])))),
                'before_widget' => $wrapper_before,
                'after_widget' => $wrapper_after,
                'before_title' => $title_before,
                'after_title' => $title_after,
            ];

            return $default_widget_args;
        }

        /**
         * Move RT Theme Option settings to the Elementor global settings
         */
        public function _v_3_0_0_compatible()
        {
            if(defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0', '>=' )){
                if(!$rt_option = get_option('rt_system_status')){
                    $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
                    $kit_id = (new \Elementor\Core\Kits\Manager())->get_active_id();

                    $meta_key = \Elementor\Core\Settings\Page\Manager::META_KEY;
                    $kit_settings = get_post_meta( $kit_id, $meta_key, true );

                    $rt_settings = [];
                    $rt_settings['container_width'] = [ 'unit' => 'px', 'size' => '1200' ];

                    $items_color = $this->_get_elementor_settings( 'system_colors' );
                    $items_fonts = $this->_get_elementor_settings( 'system_typography' );

                    $reduxArgs = new Redux;
                    $reduxArgs = $reduxArgs::$args;
                    $keys = array_keys($reduxArgs);
                    $opt_name = $keys[0];
                    $rt_theme_option = get_option( $opt_name );

                    if (empty($rt_theme_option)) {
                        return;
                    }

                    $header_font = $rt_theme_option['header-font'] ?? '';
                    $main_font   = $rt_theme_option['main-font'] ?? '';
                    $theme_color = $rt_theme_option['theme-primary-color'] ?? '';

                    $items_color[0]['color'] = esc_attr($theme_color);
                    $items_color[1]['color'] = esc_attr($header_font['color']);
                    $items_color[2]['color'] = esc_attr($main_font['color']);
                    $items_color[3]['color'] = esc_attr($theme_color);
                    $rt_settings['system_colors'] = $items_color;

                    $items_fonts[0]['typography_font_family'] = esc_attr($header_font['font-family']);
                    $items_fonts[0]['typography_font_weight'] = esc_attr($header_font['font-weight']);
                    $items_fonts[1]['typography_font_family'] = esc_attr($header_font['font-family']);
                    $items_fonts[1]['typography_font_weight'] = esc_attr($header_font['font-weight']);
                    $items_fonts[2]['typography_font_family'] = esc_attr($main_font['font-family']);
                    $items_fonts[2]['typography_font_weight'] = esc_attr($main_font['font-weight']);
                    $items_fonts[3]['typography_font_family'] = esc_attr($main_font['font-family']);
                    $items_fonts[3]['typography_font_weight'] = esc_attr($main_font['font-weight']);

                    $rt_settings['system_typography'] = $items_fonts;
                    update_option('elementor_disable_typography_schemes', 'yes');
                    update_option('rt_system_status', 'yes');

                    if (!$kit_settings) {
                        update_metadata('post', $kit_id, $meta_key, $rt_settings);
                    } else {
                        $kit_settings = array_merge($kit_settings, $rt_settings);
                        $page_settings_manager->save_settings($kit_settings, $kit_id);
                    }

                    \Elementor\Plugin::$instance->files_manager->clear_cache();
                }
            }else{
                if (!$rt_option = get_option('rt_system_status_old_e')) {
                    update_option('elementor_disable_typography_schemes', 'yes');
                    update_option('rt_system_status_old_e', 'yes');
                    \Elementor\Plugin::$instance->files_manager->clear_cache();
                }
            }
        }

        public function _get_elementor_settings($value = 'system_colors')
        {
            $kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();

            $system_items = $kit->get_settings_for_display( $value );

            if ( ! $system_items ) {
                $system_items = [];
            }

            return $system_items;
        }

        /**
         * Remove elementor node in the admin bar
         */
        function remove_admin_bar_node()
        {
            global $wp_admin_bar;

            $wp_admin_bar->remove_node( 'elementor_app_site_editor' );

            if(empty($this->admin_bar_edit_documents)){
                return;
            }

            foreach ( $this->admin_bar_edit_documents as $document ) {
                $wp_admin_bar->remove_node( 'elementor_edit_doc_' . $document->get_main_id() );
            }
        }

        /**
         * @param Post_CSS $css_file
        */
        public function add_document_to_admin_bar( $css_file )
        {
            $document = Plugin::$instance->documents->get( $css_file->get_post_id() );

            if ( $document::get_property( 'show_on_admin_bar' ) && $document->is_editable_by_current_user() ) {
                $this->admin_bar_edit_documents[ $document->get_main_id() ] = $document;
            }
        }

        /**
         * Replace elementor node in the admin bar
         *
         * @since 1.0.0
         * @access public
         *
         */
        function replace_elementor_admin_bar_title( \WP_Admin_Bar $wp_admin_bar )
        {

            if ( empty( $this->admin_bar_edit_documents ) ) {
                return;
            }

            $queried_object_id = get_queried_object_id();

            if ( is_singular() && isset( $this->admin_bar_edit_documents[ $queried_object_id ] ) ) {
                $menu_args['href'] = $this->admin_bar_edit_documents[ $queried_object_id ]->get_edit_url();
                unset( $this->admin_bar_edit_documents[ $queried_object_id ] );
            }

            foreach ( $this->admin_bar_edit_documents as $document ) {
                $title_bar = $document->get_post()->post_type && $document->get_post()->post_type !== 'elementor_library' ? $document->get_post()->post_type : $document::get_title();
                $wp_admin_bar->add_menu( [
                    'id' => 'rt_elementor_edit_doc_' . $document->get_main_id(),
                    'parent' => 'elementor_edit_page',
                    'title' => sprintf( '<span class="elementor-edit-link-title">%s</span><span class="elementor-edit-link-type">%s</span>', $document->get_post()->post_title, $title_bar ),
                    'href' => $document->get_edit_url(),
                ] );
            }

            if (
                defined('ELEMENTOR_VERSION')
                && version_compare(ELEMENTOR_VERSION, '3.0', '>=')
            ) {
                $wp_admin_bar->add_menu([
                    'id' => 'rt_elementor_app_site_editor',
                    'parent' => 'elementor_edit_page',
                    'title' => esc_html__('Open Theme Builder', 'gostudy-core'),
                    'href' => Plugin::$instance->app->get_settings('menu_url'),
                    'meta' => ['class' => 'elementor-app-link'],
                ]);
            }
        }

        /**
         * Add custom css to the admin bar
         *
         * @since 1.0.0
         * @access public
         *
         */
        public function admin_bar_style()
        {
            if(is_admin_bar_showing() && defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0', '>=' )){

                $css = '#wpadminbar #wp-admin-bar-rt_elementor_app_site_editor a.ab-item:before {
                    content: "\e91d";
                    font-family: eicons;
                    top: 4px;
                    font-size: 13px;
                    color: inherit;
                }';

                $css .= '#wpadminbar #wp-admin-bar-rt_elementor_app_site_editor a.ab-item:hover {
                    background: #4ab7f4;
                    color: #fff
                }';

                $css .= '#wpadminbar #wp-admin-bar-rt_elementor_app_site_editor a.ab-item:hover:before {
                    color: #fff
                }';

                wp_add_inline_style( 'elementor-frontend', $css );
            }
        }

        public function add_builder_to_admin_bar( Document $document, $is_excerpt )
        {
            if (
                $is_excerpt ||
                ! $document::get_property( 'show_on_admin_bar' ) ||
                ! $document->is_editable_by_current_user()
            ) {
                return;
            }

            $this->documents[ $document->get_main_id() ] = $document;
        }

        public function add_menu_in_admin_bar( $admin_bar_config )
        {

            if(empty($this->documents)){
                return;
            }

            $_key = array_keys($this->documents);
            foreach ( $_key as $condition ) {
                unset($admin_bar_config['elementor_edit_page']['children'][$condition]);
            }

            $queried_object_id = get_queried_object_id();
            if ( is_singular() && isset( $this->documents[ $queried_object_id ] ) ) {
                unset( $this->documents[ $queried_object_id ] );
            }

            $admin_bar_config['elementor_edit_page']['children'] = array_map( function ( $document ) {
                return [
                    'id' => "rt_elementor_edit_doc_{$document->get_main_id()}",
                    'title' => $document->get_post()->post_title,
                    'sub_title' => $document->get_post()->post_type && $document->get_post()->post_type !== 'elementor_library' ? $document->get_post()->post_type : $document::get_title(),
                    'href' => $document->get_edit_url(),
                ];
            }, $this->documents );

            return $admin_bar_config;
        }

        public function modify_page_structure_for_saved_templates($template)
        {
            if (
                'elementor_library' === get_post_type()
                && ($documents = Plugin::$instance->documents)
            ) {
                $current_doc = $documents->get(get_the_ID());

                if (
                    is_a($current_doc, 'Elementor\Modules\Library\Documents\Page')
                    || is_a($current_doc, 'Elementor\Modules\Library\Documents\Section')
                    || is_a($current_doc, 'ElementorPro\Modules\ThemeBuilder\Documents\Section')
                ) {
                    $elementor_templates = Plugin::$instance->modules_manager->get_modules('page-templates');
                    $elementor_template_path = $elementor_templates->get_template_path($elementor_templates::TEMPLATE_HEADER_FOOTER);

                    $template = $elementor_template_path ?: get_page_template(); //* prevent rendering through `single.php`
                }
            }

            return $template;
        }

        /**
         * Creates and returns an instance of the class
         *
         * @since 1.0.0
         * @access public
         *
         * @return object
         */
        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self;
            }

            return self::$instance;
        }
    }
}

if (!function_exists('rt_addons_elementor')) {
    function rt_addons_elementor()
    {
        return RT_Addons_Elementor::get_instance();
    }
}

rt_addons_elementor();

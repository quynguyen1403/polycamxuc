<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 *
 * @link https://themeforest.net/user/raistheme
 *
 * @package gostudy-core\includes
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class Gostudy_Core
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since 1.0.0
     * @access protected
     * @var Gostudy_Core_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since 1.0.0
     * @access protected
     * @var string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since 1.0.0
     * @access protected
     * @var string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Custom Fonts
     *
     * @since 1.0.0
     * @var string string of CSS rules
     */
    public $font_css;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if (defined('RT_CORE_VERSION')) {
            $this->version = RT_CORE_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'gostudy-core';

        $this->load_dependencies();
        $this->set_locale();

        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_cpt_hooks();

        add_filter('the_content', [$this, 'fix_shortcodes_autop']);

        // Add Custom Fonts
		add_action('init', [$this, 'custom_fonts_setup']);
		add_action('admin_head', [$this, 'admin_css_reg'] );
    }

    /**
     * Setup Custom Fonts
     *
     * @access public
     * @since 1.0.0
     */
    public function custom_fonts_setup()
    {
        if (
            class_exists('Redux')
            && class_exists('Bsf_Custom_Fonts_Taxonomy')
        ) {
            $reduxArgs = new Redux;
            $reduxArgs = $reduxArgs::$args;
            $keys = array_keys($reduxArgs);
			$opt_name = $keys[0];
            add_filter('redux/'.$opt_name.'/field/typography/custom_fonts', array($this, 'fonts_redux_list') );
        }
    }

    public function fonts_redux_list($custom_fonts)
    {
        if (class_exists('Bsf_Custom_Fonts_Taxonomy')) {
            $fontsData = Bsf_Custom_Fonts_Taxonomy::get_fonts();
            $custom_fonts = array('Custom Fonts' => []);
            if (!empty($fontsData)):
                foreach ($fontsData as $key=>$fontData):
                    $custom_fonts['Custom Fonts'][$key] = (string) $key;
                endforeach;
            endif;

            return $custom_fonts;
        }
    }

    private function render_font_css($font)
    {
        if (class_exists('Bsf_Custom_Fonts_Taxonomy')) {
            $fonts = Bsf_Custom_Fonts_Taxonomy::get_links_by_name( $font );

            foreach ($fonts as $font => $links) :
                $css = '@font-face { font-family:' . esc_attr( $font ) . ';';
                $css .= 'src:';
                $arr = [];
                if ($links['font_woff_2']) {
                    $arr[] = 'url(' . esc_url($links['font_woff_2']) . ") format('woff2')";
                }
                if ($links['font_woff']) {
                    $arr[] = 'url(' . esc_url($links['font_woff']) . ") format('woff')";
                }
                if ($links['font_ttf']) {
                    $arr[] = 'url(' . esc_url($links['font_ttf']) . ") format('truetype')";
                }
                if ($links['font_otf']) {
                    $arr[] = 'url(' . esc_url($links['font_otf']) . ") format('opentype')";
                }
                if ($links['font_svg']) {
                    $arr[] = 'url(' . esc_url($links['font_svg']) . '#' . esc_attr( strtolower( str_replace( ' ', '_', $font ) ) ) . ") format('svg')";
                }
                $css .= join(', ', $arr);
                $css .= ';';
                $css .= 'font-display: ' . esc_attr( $links['font-display'] ) . ';';
                $css .= '}';
            endforeach;
        }

        $this->font_css .= $css;
    }

    public function admin_css_reg()
    {
        if (class_exists('Bsf_Custom_Fonts_Taxonomy')) {
            $fonts = Bsf_Custom_Fonts_Taxonomy::get_fonts();
            if (!empty($fonts)) {
                foreach ($fonts as $load_font_name => $load_font) {
                    $this->render_font_css($load_font_name);
                }

                echo '<style>',
                    wp_strip_all_tags($this->font_css), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                '</style>';
            }
        }
    }

    /**
     * Create the ajax functionality of the plugin.
     *
     * @access public
     * @since 1.0.0
     */
    public function rt_ajax_init()
    {
        extract($_POST['data']);

        // Global variables blog
        global $rt_blog_atts;
        global $rt_products_atts;
        global $rt_query_vars;

        $offset_items = (int) $offset_items;
        $items_load = (int) $items_load;
        $js_offset = $js_offset ?? '';

        $out = '';
        $post_type = isset($query_args['post_type']) ? esc_attr($query_args['post_type']) : '';

        $atts = $_POST['data']['atts'] ?? $_POST['data'];

        list($query_args) = \RTAddons\Includes\RT_Loop_Settings::buildQuery($atts);


        $query_args['post_type'] = $post_type;
        $query_args['order'] = $query_args['order'] ?? 'DESC';
        $query_args['orderby'] = $query_args['orderby'] ?? 'date';
        $query_args['offset'] = $offset_items;
        $query_args['post_status'] = 'publish';
        $query_args['posts_per_page'] = $items_load;

        $js_offset = (int) $js_offset + (int) $items_load;

        $query_args['update_post_meta_cache'] = false;
        $query_args['update_post_term_cache'] = false;
        switch ($post_type) {
            case 'product':
                $tax = [];
                $product_catalog_terms = wc_get_product_visibility_term_ids();
                $product_not_in = [$product_catalog_terms['exclude-from-catalog']];
                if (!empty($product_not_in)) {
                    $tax[] = [
                        'taxonomy' => 'product_visibility',
                        'field' => 'term_taxonomy_id',
                        'terms' => $product_not_in,
                        'operator' => 'NOT IN',
                    ];
                }

                if (!empty($_GET['orderby'])) {
                    $orderby_value = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));

                    // Get order + orderby args from string
                    $orderby_value = explode('-', $orderby_value);
                    $orderby = esc_attr($orderby_value[0]);
                    $order = !empty($orderby_value[1]) ? $orderby_value[1] : $order;

                    $orderby = strtolower($orderby);
                    $order = strtoupper($order);

                    $ordering_args = WC()->query->get_catalog_ordering_args($orderby, $order);
                    $meta_query = WC()->query->get_meta_query();

                    $query_args['orderby'] = $ordering_args['orderby'];
                    $query_args['order'] = $ordering_args['order'];

                    if ($ordering_args['meta_key']) {
                        $query_args['meta_key'] = $ordering_args['meta_key'];
                    }

                    if ($_GET['orderby'] === 'price') {
                        $query_args['order'] = 'ASC';
                    }
                }

                $query_args['tax_query'][] = $tax;
                break;
        }

        $q = new WP_Query($query_args);

        $found_posts = $q->found_posts;

        if ($offset_items + $items_load >= (int) $q->found_posts) {
            $out .= "<div class='hidden_load_more'></div>";
        }

        $out .= "<div class='js_offset_items' data-offset='" . esc_attr($js_offset) . "'></div>";

        switch ($post_type) {
            case 'portfolio':
                $custom_post = new \RTAddons\Templates\RTPortfolio;
                $out .= $custom_post->output_loop_query($q, $_POST['data']);
                break;

            case 'product':
                $rt_products_atts = $_POST['data'];
                $rt_query_vars = $q;
                $out .= get_template_part('templates/shop/products', $products_style ?? 'grid');

                $out .= '<p class="woocommerce-result-count">';

                $paged = max(1, $q->get('paged'));
                $per_page = $offset_items + $items_load;
                $total = $q->found_posts;
                $first = ($per_page * $paged) - $per_page + 1;
                $last = min($total, ($offset_items + $items_load) * $paged);

                if (1 == $total) {
                    $out .= esc_html__('Showing the single result', 'gostudy-core');
                } elseif ($total <= $per_page || -1 == $per_page) {
                    $out .= sprintf(esc_html__('Showing all %d results', 'gostudy-core'), $total);
                } else {
                    $out .= sprintf(_x('Showing <strong>%1$d&ndash;%2$d</strong> of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'gostudy-core'), $first, $last, $total);
                }

                $out .= '</p>';
                break;

            default:
                $rt_blog_atts = $_POST['data'];
                $rt_query_vars = $q;
                $out .= get_template_part('templates/post/post', $blog_style ?? 'standard');
                break;
        }

        wp_reset_postdata();
        echo $out;

        unset($rt_blog_atts);
        unset($rt_products_atts);
        unset($rt_query_vars);

        wp_die();
    }

    /**
     * Create the ajax functionality mega menu of the plugin.
     *
     * @since 1.0.0
     * @access public
     */
    public function rt_mega_menu_load_ajax()
    {
        extract($_POST);

        // Global variables blog
        global $rt_blog_atts;
        global $rt_query_vars;

        $out = '';
        list($query_args) = \RTAddons\Includes\RT_Loop_Settings::buildQuery($_POST);

        $query_args['cat'] = $id;
        $query_args['order'] = 'DESC';
        $query_args['orderby'] = 'date';
        $query_args['post_status'] = 'publish';
        $query_args['posts_per_page'] = $posts_count;

        $query_args['no_found_rows'] = true;
        $query_args['update_post_meta_cache'] = false;
        $query_args['update_post_term_cache'] = false;

        $q = \RTAddons\Includes\RT_Loop_Settings::cache_query($query_args);

        $rt_blog_atts = $_POST;
        $rt_query_vars = $q;
        $out .= get_template_part('templates/post/post', 'mega_menu');

        wp_reset_postdata();

        $out .= "<div class='items_id' data-identifier='" . esc_attr($id) . "'></div>";
        echo $out;

        unset($rt_blog_atts);
        unset($rt_query_vars);

        wp_die();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Gostudy_Core_Loader. Orchestrates the hooks of the plugin.
     * - Gostudy_Core_i18n. Defines internationalization functionality.
     * - Gostudy_Core_Admin. Defines all hooks for the admin area.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since 1.0.0
     * @access private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-rt-core-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-rt-core-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-rt-core-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         *
         * @deprecated 1.0.0
         */
        // require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-rt-core-public.php';

        /**
         * Include Redux Framework.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/framework/class.redux-plugin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/framework/init.php';

        /**
         * Include Redux Framework Loader https://github.com/reduxframework/redux-extensions-loader
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/redux-extension-loader.php';

        /**
         * Include MetaBoxes IO.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/meta-box/meta-box.php';

        /**
         * Include MetaBoxes IO Addon.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/meta-box-extensions/social_field.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/meta-box-extensions/select_icon_field.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/meta-box-extensions/heading_field.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/meta-box-extensions/background_field/background_field.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/meta-box-extensions/offset_field.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/meta-box-extensions/font_field.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/meta-box-extensions/image-select_field.php';

        /**
         * Post type register
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/post-types/post-types-register.php';
        /**
         * Include Theme Helper
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/theme-helper-functions.php';

        /**
         * Include Theme Helper Class.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/theme-helper/theme-helper.php';

        /**
         * Include RT Likes.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/rt_likes/likes.php';

        /**
         * Include Aqua Resizer.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/aq_resizer/aq_resizer.php';

        /**
         * Include Widgets.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/widgets/posts.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/widgets/tutor-course.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/widgets/lp-course.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/widgets/ld-course.php';
        


        /**
         * Include Elementor Extensions.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/elementor/init.php';

        $this->loader = new Gostudy_Core_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Gostudy_Core_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since 1.0.0
     * @access private
     */
    private function set_locale()
    {
        $plugin_i18n = new Gostudy_Core_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since 1.0.0
     * @access private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Gostudy_Core_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }


    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since 1.0.0
     * @access private
     */
    private function define_public_hooks()
    {
        add_action('wp_ajax_rt_ajax', [$this, 'rt_ajax_init']);
        add_action('wp_ajax_nopriv_rt_ajax', [$this, 'rt_ajax_init']);

        add_action('wp_ajax_rt_mega_menu_load_ajax', [$this, 'rt_mega_menu_load_ajax']);
        add_action('wp_ajax_nopriv_rt_mega_menu_load_ajax', [$this, 'rt_mega_menu_load_ajax']);
    }

    /**
     * Fix Shortcode
     *
     * @since  1.0.0
     * @access public
     */
    public function fix_shortcodes_autop($content)
    {
        $array = [
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        ];

        $content = strtr($content, $array);

        return $content;
    }

    /**
     * Register 'custom' post type.
     *
     * @since 1.0.0
     * @access private
     */
    private function define_cpt_hooks()
    {
        $plugin_cpt = RTPostTypesRegister::getInstance();
        // Add post type.
        $this->loader->add_action('after_setup_theme', $plugin_cpt, 'init');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since 1.0.0
     * @return string The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since 1.0.0
     * @return Gostudy_Core_Loader Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since 1.0.0
     * @return string The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}

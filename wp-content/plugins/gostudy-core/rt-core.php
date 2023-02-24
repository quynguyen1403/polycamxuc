<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeforest.net/user/raistheme
 * @since             1.0.0
 * @package           gostudy-core
 *
 * @wordpress-plugin
 * Plugin Name:       Gostudy Core
 * Plugin URI:        https://themeforest.net/user/raistheme
 * Description:       Core plugin for Gostudy Theme.
 * Version:           2.1.4
 * Author:            RaisTheme
 * Author URI:        https://themeforest.net/user/raistheme
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gostudy-core
 * Domain Path:       /languages
 */

defined('WPINC') || die; // Abort, if called directly.


/**
 * Current version of the plugin.
 */
$plugin_data = get_file_data(__FILE__, ['version' => 'Version']);
define('RT_CORE_VERSION', $plugin_data['version']);

class Gostudy_CorePlugin
{
    private static $minimum_php_version = '7.0';

    public function __construct()
    {
        add_action('admin_init', [$this, 'check_version']);
        if (!self::theme_is_compatible()) {
            return;
        }

        if (version_compare(PHP_VERSION, self::$minimum_php_version, '<')) {
            add_action('admin_notices', [$this, 'fail_php_version']);
        }

        add_action( 'init', array ( $this, 'gostudy_after_setup_theme' ) );
    }

    /**
     * The backup sanity check, in case the plugin is activated in a weird way,
     * or the theme change after activation.
     */
    public function check_version()
    {
        if (
            !self::theme_is_compatible()
            && is_plugin_active(plugin_basename(__FILE__))
        ) {
            deactivate_plugins(plugin_basename(__FILE__));
            add_action('admin_notices', [$this, 'disabled_notice']);
            if (isset($_GET['activate'])) {
                unset($_GET['activate']);
            }
        }
    }

    public function fail_php_version()
    {
        $message = sprintf(
            __('Gostudy Core plugin requires PHP version %s+. Your current PHP version is %s.', 'gostudy-core'),
            self::$minimum_php_version,
            PHP_VERSION
        );

        echo '<div class="error"><p>', esc_html($message), '</p></div>';
    }

    // Add Image size
    public function gostudy_after_setup_theme() {
        add_image_size('team_thumb', 340, 480, true);
    }

    public static function activation_check()
    {
        if (!self::theme_is_compatible()) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('Gostudy Core plugin compatible with Gostudy theme only!', 'gostudy-core'));
        }
    }

    public function disabled_notice()
    {
        echo '<strong>',
            esc_html__('Gostudy Core plugin compatible with Gostudy theme only!', 'gostudy-core'),
        '</strong>';
    }

    public static function theme_is_compatible()
    {
        $plugin_name = trim(dirname(plugin_basename(__FILE__)));
        $theme_name = self::get_theme_slug();

        return false !== stripos($plugin_name, $theme_name);
    }

    public static function get_theme_slug()
    {
        return str_replace('-child', '', wp_get_theme()->get('TextDomain'));
    }


}

new Gostudy_CorePlugin();

register_activation_hook(__FILE__, ['Gostudy_CorePlugin', 'activation_check']);


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rt-core-activator.php
 */
function activate_gostudy_core()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-rt-core-activator.php';
    Gostudy_Core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rt-core-deactivator.php
 */
function deactivate_gostudy_core()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-rt-core-deactivator.php';
    Gostudy_Core_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_gostudy_core');
register_deactivation_hook(__FILE__, 'deactivate_gostudy_core');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-rt-core.php';

/**
 * Start execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_gostudy_core()
{
    (new Gostudy_Core())->run();
}

run_gostudy_core();



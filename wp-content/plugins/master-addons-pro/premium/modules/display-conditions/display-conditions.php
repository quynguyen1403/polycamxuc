<?php

namespace MasterAddons\Modules;
// Elementor classes
use \Elementor\Controls_Manager;
use \Elementor\Repeater;

use MasterAddons\Inc\Controls\JLTMA_Control_Query as QueryControl;
use MasterAddons\Inc\Helper\Master_Addons_Helper as Utils;

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly.

/**
 * Author Name: Liton Arefin
 * Author URL: https://jeweltheme.com
 * Date: 10/14/19
 */

class JLTMA_Display_Conditions
{

	private   static $instance = null;
	public    $has_controls    = true;
	protected $is_common       = true;
	protected $conditions      = [];
	protected $_conditions     = [];
	protected $_conditional_repeater;
	protected $conditions_options = [];

	public function __construct()
	{
		$this->add_actions();
	}

	protected function add_actions()
	{
		$this->set_conditions_options();
		add_action('elementor/element/common/_section_style/after_section_end', [$this, 'register_section']);
		add_action('elementor/element/section/section_advanced/after_section_end', [$this, 'register_section']);

		add_action('elementor/element/common/jltma_section_display_conditions/before_section_end', [$this, 'register_controls'], 10, 2);
		add_action('elementor/element/section/jltma_section_display_conditions/before_section_end', [$this, 'register_controls'], 10, 2);


		// Conditions for widgets
		add_action('elementor/widget/render_content', function ($widget_content, $element) {

			$settings = $element->get_settings();

			if (isset($settings['jltma_display_conditions_enable']) && 'yes' === $settings['jltma_display_conditions_enable']) {

				// Set the conditions
				$this->set_conditions($element->get_id(), $settings['jltma_display_conditions']);

				// if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				// 	ob_start();
				// 	$this->render_editor_notice( $settings );
				// 	$widget_content .= ob_get_clean();
				// }

				if (!$this->is_visible($element->get_id(), $settings['jltma_display_conditions_relation'])) { // Check the conditions
					if ('yes' !== $settings['jltma_display_conditions_output']) {
						return; // And on frontend we stop the rendering of the widget
					}
				}
			}

			return $widget_content;
		}, 10, 2);

		// Conditions for widgets
		add_action('elementor/frontend/widget/before_render', function ($element) {

			$settings = $element->get_settings();

			if (isset($settings['jltma_display_conditions_enable']) && 'yes' === $settings['jltma_display_conditions_enable']) {

				// Set the conditions
				$this->set_conditions($element->get_id(), $settings['jltma_display_conditions']);

				if (!$this->is_visible($element->get_id(), $settings['jltma_display_conditions_relation'])) { // Check the conditions
					$element->add_render_attribute('_wrapper', 'class', 'jltma-conditions-hidden');
				}
			}
		}, 10, 1);


		// Conditions for sections
		add_action('elementor/frontend/section/before_render', function ($element) {

			$settings = $element->get_settings();

			if (isset($settings['jltma_display_conditions_enable']) && 'yes' === $settings['jltma_display_conditions_enable']) {

				// Set the conditions
				$this->set_conditions($element->get_id(), $settings['jltma_display_conditions']);

				if (!$this->is_visible($element->get_id(), $settings['jltma_display_conditions_relation'])) { // Check the conditions
					$element->add_render_attribute('_wrapper', 'class', 'jltma-conditions-hidden');
				}
			}
		}, 10, 1);
	}



	protected function render_editor_notice($settings)
	{ ?>
		<span>
			<?php echo esc_html__('This widget is displayed conditionally.', 'master-addons' ); ?>
		</span>
<?php
	}


	public function register_section($element)
	{
		$element->start_controls_section(
			'jltma_section_display_conditions',
			[
				'label'     => JLTMA_BADGE . __(' Display Conditions', 'master-addons' ),
				'tab'       => Controls_Manager::TAB_ADVANCED
			]
		);

		$element->end_controls_section();
	}


	// Set the Conditions options array
	private function set_conditions_options()
	{

		$this->conditions_options = [
			[
				'label'   => esc_html__('Visitor', 'master-addons' ),
				'options' => [
					'authentication' => esc_html__('Login Status', 'master-addons' ),
					'role'           => esc_html__('User Role', 'master-addons' ),
					'os'             => esc_html__('Operating System', 'master-addons' ),
					'browser'        => esc_html__('Browser', 'master-addons' ),
				],
			],
			[
				'label'   => esc_html__('Date & Time', 'master-addons' ),
				'options' => [
					'date' => esc_html__('Date Range', 'master-addons' ),
					'time' => esc_html__('Time of Day', 'master-addons' ),
					'day'  => esc_html__('Day of Week', 'master-addons' ),
				],
			],
			[
				'label'   => esc_html__('Single', 'master-addons' ),
				'options' => [
					'page'        => esc_html__('Page', 'master-addons' ),
					'post'        => esc_html__('Post', 'master-addons' ),
					'static_page' => esc_html__('Static Page', 'master-addons' ),
					'post_type'   => esc_html__('Post Type', 'master-addons' ),
				],
			],
			[
				'label'   => esc_html__('Archive', 'master-addons' ),
				'options' => [
					'taxonomy_archive'  => esc_html__('Taxonomy', 'master-addons' ),
					'term_archive'      => esc_html__('Term', 'master-addons' ),
					'post_type_archive' => esc_html__('Post Type', 'master-addons' ),
					'date_archive'      => esc_html__('Date', 'master-addons' ),
					'author_archive'    => esc_html__('Author', 'master-addons' ),
					'search_results'    => esc_html__('Search', 'master-addons' ),
				],
			],
		];

		// EDD Conditions
		if (class_exists('Easy_Digital_Downloads', false)) {
			$this->conditions_options[] = [
				'label'   => esc_html__('Easy Digital Downloads', 'master-addons' ),
				'options' => [
					'edd_cart' => esc_html__('Cart', 'master-addons' ),
				],
			];
		}
	}


	public function register_controls($element, $args)
	{

		global $wp_roles;

		$default_date_start = date('Y-m-d', strtotime('-3 day') + (get_option('gmt_offset') * HOUR_IN_SECONDS));
		$default_date_end     = date('Y-m-d', strtotime('+3 day') + (get_option('gmt_offset') * HOUR_IN_SECONDS));
		$default_interval     = $default_date_start . ' to ' . $default_date_end;

		$element_type = $element->get_type();

		$element->add_control(
			'jltma_display_conditions_enable',
			[
				'label'              => esc_html__('Display Conditions', 'master-addons' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => '',
				'label_on'           => esc_html__('Yes', 'master-addons' ),
				'label_off'          => esc_html__('No', 'master-addons' ),
				'return_value'       => 'yes',
				'frontend_available' => true,
			]
		);

		if ('widget' === $element_type) {
			$element->add_control(
				'jltma_display_conditions_output',
				[
					'label'              => esc_html__('Output HTML', 'master-addons' ),
					'description'        => /* translators: %s: Element Type. */ sprintf(esc_html__('If enabled, the HTML code will exist on the page but the %s will be hidden using CSS.', 'master-addons' ), $element_type),
					'default'            => '',
					'type'               => Controls_Manager::SWITCHER,
					'label_on'           => esc_html__('Yes', 'master-addons' ),
					'label_off'          => esc_html__('No', 'master-addons' ),
					'return_value'       => 'yes',
					'frontend_available' => true,
					'content_classes'    => 'elementor-panel-alert elementor-panel-alert-warning',
					'condition'          => [
						'jltma_display_conditions_enable' => 'yes',
					],
				]
			);
		}

		$element->add_control(
			'jltma_display_conditions_relation',
			[
				'label'   => esc_html__('Display on', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all' => esc_html__('All conditions met', 'master-addons' ),
					'any' => esc_html__('Any condition met', 'master-addons' ),
				],
				'condition'    => [
					'jltma_display_conditions_enable' => 'yes',
				],
			]
		);



		$repeater = new Repeater();

		$repeater->add_control(
			'jltma_condition_key',
			[
				'type'         => Controls_Manager::SELECT,
				'default'     => 'authentication',
				'label_block' => true,
				'groups'     => $this->conditions_options,
			]
		);

		$repeater->add_control(
			'jltma_condition_operator',
			[
				'type'        => Controls_Manager::SELECT,
				'default'     => 'is',
				'label_block' => true,
				'options'     => [
					'is'  => esc_html__('Is', 'master-addons' ),
					'not' => esc_html__('Is not', 'master-addons' ),
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_authentication_value',
			[
				'type'        => Controls_Manager::SELECT,
				'default'     => 'authenticated',
				'label_block' => true,
				'options'     => [
					'authenticated' => esc_html__('Logged in', 'master-addons' ),
				],
				'condition' => [
					'jltma_condition_key' => 'authentication',
				],
			]
		);;

		$repeater->add_control(
			'jltma_condition_role_value',
			[
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__('Warning: This condition applies only to logged in visitors.', 'master-addons' ),
				'default'     => 'subscriber',
				'label_block' => true,
				'options'     => $wp_roles->get_names(),
				'condition'   => [
					'jltma_condition_key' => 'role',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_date_value',
			[
				'label'          => esc_html__('In interval', 'master-addons' ),
				'type'           => \Elementor\Controls_Manager::DATE_TIME,
				'picker_options' => [
					'enableTime' => false,
					'mode'       => 'range',
				],
				'label_block' => true,
				'default'     => $default_interval,
				'condition'   => [
					'jltma_condition_key' => 'date',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_time_value',
			[
				'label'          => esc_html__('Before', 'master-addons' ),
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => [
					'dateFormat' => "H:i",
					'enableTime' => true,
					'noCalendar' => true,
				],
				'label_block' => true,
				'default'     => '',
				'condition'   => [
					'jltma_condition_key' => 'time',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_day_value',
			[
				'label'       => esc_html__('Before', 'master-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'placeholder' => esc_html__('Any', 'master-addons' ),
				'multiple'    => true,
				'options'     => [
					'1' => esc_html__('Monday', 'master-addons' ),
					'2' => esc_html__('Tuesday', 'master-addons' ),
					'3' => esc_html__('Wednesday', 'master-addons' ),
					'4' => esc_html__('Thursday', 'master-addons' ),
					'5' => esc_html__('Friday', 'master-addons' ),
					'6' => esc_html__('Saturday', 'master-addons' ),
					'7' => esc_html__('Sunday', 'master-addons' ),
				],
				'label_block' => true,
				'default'     => 'Monday',
				'condition'   => [
					'jltma_condition_key' => 'day',
				],
			]
		);

		$os_options = $this->get_os_options();

		$repeater->add_control(
			'jltma_condition_os_value',
			[
				'type'        => Controls_Manager::SELECT,
				'default'     => array_keys($os_options)[0],
				'label_block' => true,
				'options'     => $os_options,
				'condition'   => [
					'jltma_condition_key' => 'os',
				],
			]
		);

		$browser_options = $this->get_browser_options();

		$repeater->add_control(
			'jltma_condition_browser_value',
			[
				'type'        => Controls_Manager::SELECT,
				'default'     => array_keys($browser_options)[0],
				'label_block' => true,
				'options'     => $browser_options,
				'condition'   => [
					'jltma_condition_key' => 'browser',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_page_value',
			[
				'type'        => 'jltma_query',
				'default'     => '',
				'placeholder' => esc_html__('Any', 'master-addons' ),
				'description' => esc_html__('Leave blank for any page.', 'master-addons' ),
				'label_block' => true,
				'multiple'    => true,
				'query_type'  => 'posts',
				'object_type' => 'page',
				'condition'   => [
					'jltma_condition_key' => 'page',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_post_value',
			[
				'type'        => 'jltma_query',
				'default'     => '',
				'placeholder' => esc_html__('Any', 'master-addons' ),
				'description' => esc_html__('Leave blank for any post.', 'master-addons' ),
				'label_block' => true,
				'multiple'    => true,
				'query_type'  => 'posts',
				'object_type' => '',
				'condition'   => [
					'jltma_condition_key' => 'post',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_static_page_value',
			[
				'type'        => Controls_Manager::SELECT,
				'default'     => 'home',
				'label_block' => true,
				'options'     => [
					'home'   => esc_html__('Default Homepage', 'master-addons' ),
					'static' => esc_html__('Static Homepage', 'master-addons' ),
					'blog'   => esc_html__('Blog Page', 'master-addons' ),
					'404'    => esc_html__('404 Page', 'master-addons' ),
				],
				'condition'     => [
					'jltma_condition_key' => 'static_page',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_post_type_value',
			[
				'type'        => Controls_Manager::SELECT2,
				'default'     => '',
				'placeholder' => esc_html__('Any', 'master-addons' ),
				'description' => esc_html__('Leave blank or select all for any post type.', 'master-addons' ),
				'label_block' => true,
				'multiple'    => true,
				'options'     => Utils::ma_el_get_post_types(),
				'condition'   => [
					'jltma_condition_key' => 'post_type',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_taxonomy_archive_value',
			[
				'type'        => Controls_Manager::SELECT2,
				'default'     => '',
				'placeholder' => esc_html__('Any', 'master-addons' ),
				'description' => esc_html__('Leave blank or select all for any taxonomy archive.', 'master-addons' ),
				'multiple'    => true,
				'label_block' => true,
				'options'     => Utils::get_taxonomies_options(),
				'condition'   => [
					'jltma_condition_key' => 'taxonomy_archive',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_term_archive_value',
			[
				'label'        => esc_html__('Term', 'elementor-pro'),
				'description'  => esc_html__('Leave blank or select all for any term archive.', 'master-addons' ),
				'type'         => 'jltma_query',
				'post_type'    => '',
				'options'      => [],
				'label_block'  => true,
				'multiple'     => true,
				'query_type'   => 'terms',
				'include_type' => true,
				'condition'    => [
					'jltma_condition_key' => 'term_archive',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_post_type_archive_value',
			[
				'type'        => Controls_Manager::SELECT2,
				'default'     => '',
				'placeholder' => esc_html__('Any', 'master-addons' ),
				'description' => esc_html__('Leave blank or select all for any post type.', 'master-addons' ),
				'multiple'    => true,
				'label_block' => true,
				'options'     => Utils::ma_el_get_post_types(),
				'condition'   => [
					'jltma_condition_key' => 'post_type_archive',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_date_archive_value',
			[
				'type'        => Controls_Manager::SELECT2,
				'default'     => '',
				'placeholder' => esc_html__('Any', 'master-addons' ),
				'description' => esc_html__('Leave blank or select all for any date based archive.', 'master-addons' ),
				'multiple'    => true,
				'label_block' => true,
				'options'     => [
					'day'   => esc_html__('Day', 'master-addons' ),
					'month' => esc_html__('Month', 'master-addons' ),
					'year'  => esc_html__('Year', 'master-addons' ),
				],
				'condition'     => [
					'jltma_condition_key' => 'date_archive',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_author_archive_value',
			[
				'type'        => 'jltma_query',
				'default'     => '',
				'placeholder' => esc_html__('Any', 'master-addons' ),
				'description' => esc_html__('Leave blank for all authors.', 'master-addons' ),
				'multiple'    => true,
				'label_block' => true,
				'query_type'  => 'authors',
				'condition'   => [
					'jltma_condition_key' => 'author_archive',
				],
			]
		);

		$repeater->add_control(
			'jltma_condition_search_results_value',
			[
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__('Keywords', 'master-addons' ),
				'description' => esc_html__('Enter keywords, separated by commas, to condition the display on specific keywords and leave blank for any.', 'master-addons' ),
				'label_block' => true,
				'condition'   => [
					'jltma_condition_key' => 'search_results',
				],
			]
		);

		if (class_exists('Easy_Digital_Downloads', false)) {
			$repeater->add_control(
				'jltma_condition_edd_cart_value',
				[
					'type'        => Controls_Manager::SELECT,
					'default'     => 'empty',
					'label_block' => true,
					'options'     => [
						'empty' => esc_html__('Empty', 'master-addons' ),
					],
					'condition'     => [
						'jltma_condition_key' => 'edd_cart',
					],
				]
			);
		}

		$element->add_control(
			'jltma_display_conditions',
			[
				'label'   => esc_html__('Conditions', 'master-addons' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[
						'jltma_condition_key'                  => 'authentication',
						'jltma_condition_operator'             => 'is',
						'jltma_condition_authentication_value' => 'authenticated',
					],
				],
				'condition'        => [
					'jltma_display_conditions_enable' => 'yes',
				],
				'title_field' => 'Condition',
			]
		);
	}


	// Get OS options for control
	protected function get_os_options()
	{
		return [
			'iphone'     => 'iPhone',
			'windows'    => 'Windows',
			'open_bsd'   => 'OpenBSD',
			'sun_os'     => 'SunOS',
			'linux'      => 'Linux',
			'safari'     => 'Safari',
			'mac_os'     => 'Mac OS',
			'qnx'        => 'QNX',
			'beos'       => 'BeOS',
			'os2'        => 'OS/2',
			'search_bot' => 'Search Bot',
		];
	}


	// Get browser options for control
	protected function get_browser_options()
	{
		return [
			'ie'         => __('Internet Explorer', 'master-addons' ),
			'firefox'    => __('Mozilla Firefox', 'master-addons' ),
			'chrome'     => __('Google Chrome', 'master-addons' ),
			'opera_mini' => __('Opera Mini', 'master-addons' ),
			'opera'      => __('Opera', 'master-addons' ),
			'safari'     => __('Safari', 'master-addons' ),
		];
	}


	/**
	 * Set conditions.
	 * Sets the conditions property to all conditions comparison values
	 */
	protected function set_conditions($id, $conditions = [])
	{
		if (!$conditions)
			return;

		foreach ($conditions as $index => $condition) {
			$key      = $condition['jltma_condition_key'];
			$operator = $condition['jltma_condition_operator'];
			$value    = $condition['jltma_condition_' . $key . '_value'];

			if (method_exists($this, 'check_' . $key)) {
				$check = call_user_func([$this, 'check_' . $key], $value, $operator);
				$this->conditions[$id][$key . '_' . $condition['_id']] = $check;
			}
		}
	}


	/**
	 * Check conditions.
	 *
	 * Checks for all or any conditions and returns true or false
	 * depending on wether the content can be shown or not
	 */
	protected function is_visible($id, $relation)
	{

		if (!array_key_exists($id, $this->conditions))
			return;

		if (!\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			if ('any' === $relation) {
				if (!in_array(true, $this->conditions[$id]))
					return false;
			} else {
				if (in_array(false, $this->conditions[$id]))
					return false;
			}
		}

		return true;
	}


	// Compare conditions
	protected static function compare($left_value, $right_value, $operator)
	{
		switch ($operator) {
			case 'is':
				return $left_value == $right_value;
			case 'not':
				return $left_value != $right_value;
			default:
				return $left_value === $right_value;
		}
	}

	// Check user login status
	protected static function check_authentication($value, $operator)
	{
		return self::compare(is_user_logged_in(), true, $operator);
	}


	// Check user role
	protected static function check_role($value, $operator)
	{

		$user = wp_get_current_user();
		return self::compare(is_user_logged_in() && in_array($value, $user->roles), true, $operator);
	}


	// Check date interval
	protected static function check_date($value, $operator)
	{

		// Split control valur into two dates
		$intervals = explode('to', preg_replace('/\s+/', '', $value));

		// Make sure the explode return an array with exactly 2 indexes
		if (!is_array($intervals) || 2 !== count($intervals))
			return;

		// Set start and end dates
		$start     = $intervals[0];
		$end     = $intervals[1];
		$today     = date('Y-m-d');

		// Default returned bool to false
		$show     = false;

		// Check vars
		if (
			\DateTime::createFromFormat('Y-m-d', $start) === false || // Make sure it's a date
			\DateTime::createFromFormat('Y-m-d', $end) === false
		) // Make sure it's a date
			return;

		// Convert to timestamp
		$start_ts     = strtotime($start) + (get_option('gmt_offset') * HOUR_IN_SECONDS);
		$end_ts     = strtotime($end) + (get_option('gmt_offset') * HOUR_IN_SECONDS);
		$today_ts     = strtotime($today) + (get_option('gmt_offset') * HOUR_IN_SECONDS);

		// Check that user date is between start & end
		$show = (($today_ts >= $start_ts) && ($today_ts <= $end_ts));

		return self::compare($show, true, $operator);
	}


	// Check time of day interval
	protected static function check_time($value, $operator)
	{

		// Split control valur into two dates
		$time     = date('H:i', strtotime(preg_replace('/\s+/', '', $value)));
		$now     = date('H:i', strtotime("now") + (get_option('gmt_offset') * HOUR_IN_SECONDS));

		// Default returned bool to false
		$show     = false;

		// Check vars
		if (\DateTime::createFromFormat('H:i', $time) === false) // Make sure it's a valid DateTime format
			return;

		// Convert to timestamp
		$time_ts     = strtotime($time);
		$now_ts     = strtotime($now);

		// Check that user date is between start & end
		$show = ($now_ts < $time_ts);

		return self::compare($show, true, $operator);
	}

	// Check day of week
	protected static function check_day($value, $operator)
	{

		$show = false;

		if (is_array($value) && !empty($value)) {
			foreach ($value as $_key => $_value) {
				if ($_value === date('w')) {
					$show = true;
					break;
				}
			}
		} else {
			$show = $value === date('w');
		}

		return self::compare($show, true, $operator);
	}

	// Check operating system of visitor
	protected static function check_os($value, $operator)
	{

		$oses = [
			'iphone'            => '(iPhone)',
			'windows'             => 'Win16|(Windows 95)|(Win95)|(Windows_95)|(Windows 98)|(Win98)|(Windows NT 5.0)|(Windows 2000)|(Windows NT 5.1)|(Windows XP)|(Windows NT 5.2)|(Windows NT 6.0)|(Windows Vista)|(Windows NT 6.1)|(Windows 7)|(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)|Windows ME',
			'open_bsd'          => 'OpenBSD',
			'sun_os'            => 'SunOS',
			'linux'             => '(Linux)|(X11)',
			'safari'            => '(Safari)',
			'mac_os'            => '(Mac_PowerPC)|(Macintosh)',
			'qnx'               => 'QNX',
			'beos'              => 'BeOS',
			'os2'                  => 'OS/2',
			'search_bot'        => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)',
		];

		return self::compare(preg_match('@' . $oses[$value] . '@', $_SERVER['HTTP_USER_AGENT']), true, $operator);
	}

	// Check browser of visitor
	protected static function check_browser($value, $operator)
	{

		$browsers = [
			'ie'            => [
				'MSIE',
				'Trident',
			],
			'firefox'        => 'Firefox',
			'chrome'        => 'Chrome',
			'opera_mini'    => 'Opera Mini',
			'opera'            => 'Opera',
			'safari'        => 'Safari',
		];

		$show = false;

		if ('ie' === $value) {
			if (false !== strpos($_SERVER['HTTP_USER_AGENT'], $browsers[$value][0]) || false !== strpos($_SERVER['HTTP_USER_AGENT'], $browsers[$value][1])) {
				$show = true;
			}
		} else {
			if (false !== strpos($_SERVER['HTTP_USER_AGENT'], $browsers[$value])) {
				$show = true;

				// Additional check for Chrome that returns Safari
				if ('safari' === $value || 'firefox' === $value) {
					if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
						$show = false;
					}
				}
			}
		}


		return self::compare($show, true, $operator);
	}

	// Check current page
	protected static function check_page($value, $operator)
	{
		$show = false;

		if (is_array($value) && !empty($value)) {
			foreach ($value as $_key => $_value) {
				if (is_page($_value)) {
					$show = true;
					break;
				}
			}
		} else {
			$show = is_page($value);
		}

		return self::compare($show, true, $operator);
	}

	// Check current post
	protected static function check_post($value, $operator)
	{
		$show = false;

		if (is_array($value) && !empty($value)) {
			foreach ($value as $_key => $_value) {
				if (is_single($_value) || is_singular($_value)) {
					$show = true;
					break;
				}
			}
		} else {
			$show = is_single($value) || is_singular($value);
		}

		return self::compare($show, true, $operator);
	}

	// Check browser of visitor
	protected static function check_static_page($value, $operator)
	{

		if ('home' === $value) {
			return self::compare((is_front_page() && is_home()), true, $operator);
		} elseif ('static' === $value) {
			return self::compare((is_front_page() && !is_home()), true, $operator);
		} elseif ('blog' === $value) {
			return self::compare((!is_front_page() && is_home()), true, $operator);
		} elseif ('404' === $value) {
			return self::compare(is_404(), true, $operator);
		}
	}

	// Check current post type
	protected static function check_post_type($value, $operator)
	{
		$show = false;

		if (is_array($value) && !empty($value)) {
			foreach ($value as $_key => $_value) {
				if (is_singular($_value)) {
					$show = true;
					break;
				}
			}
		} else {
			$show = is_singular($value);
		}

		return self::compare($show, true, $operator);
	}

	// Check current taxonomy archive
	protected static function check_taxonomy_archive($value, $operator)
	{
		$show = false;

		if (is_array($value) && !empty($value)) {
			foreach ($value as $_key => $_value) {

				$show = self::check_taxonomy_archive_type($_value);

				if ($show) break;
			}
		} else {
			$show = self::check_taxonomy_archive_type($value);
		}

		return self::compare($show, true, $operator);
	}

	// Checks a given taxonomy against the current page template
	protected static function check_taxonomy_archive_type($taxonomy)
	{
		if ('category' === $taxonomy) {
			return is_category();
		} else if ('post_tag' === $taxonomy) {
			return is_tag();
		} else if ('' === $taxonomy || empty($taxonomy)) {
			return is_tax() || is_category() || is_tag();
		} else {
			return is_tax($taxonomy);
		}

		return false;
	}

	// Check current taxonomy term archive
	protected static function check_term_archive($value, $operator)
	{
		$show = false;

		if (is_array($value) && !empty($value)) {
			foreach ($value as $_key => $_value) {

				$show = self::check_term_archive_type($_value);

				if ($show) break;
			}
		} else {
			$show = self::check_term_archive_type($value);
		}

		return self::compare($show, true, $operator);
	}

	// Checks a given taxonomy term against the current page template
	protected static function check_term_archive_type($term)
	{

		if (is_category($term)) {
			return true;
		} else if (is_tag($term)) {
			return true;
		} else if (is_tax()) {
			if (is_tax(get_queried_object()->taxonomy, $term)) {
				return true;
			}
		}

		return false;
	}

	// Check current post type archive
	protected static function check_post_type_archive($value, $operator)
	{
		$show = false;

		if (is_array($value) && !empty($value)) {
			foreach ($value as $_key => $_value) {
				if (is_post_type_archive($_value)) {
					$show = true;
					break;
				}
			}
		} else {
			$show = is_post_type_archive($value);
		}

		return self::compare($show, true, $operator);
	}

	// Check current date archive
	protected static function check_date_archive($value, $operator)
	{
		$show = false;

		if (is_array($value) && !empty($value)) {
			foreach ($value as $_key => $_value) {
				if (self::check_date_archive_type($_value)) {
					$show = true;
					break;
				}
			}
		} else {
			$show = is_date($value);
		}

		return self::compare($show, true, $operator);
	}

	// Checks a given date type against the current page template
	protected static function check_date_archive_type($type)
	{
		if ('day' === $type) { // Day
			return is_day();
		} elseif ('month' === $type) { // Month
			return is_month();
		} elseif ('year' === $type) { // Year
			return is_year();
		}

		return false;
	}

	// Check current author archive
	protected static function check_author_archive($value, $operator)
	{
		$show = false;

		if (is_array($value) && !empty($value)) {
			foreach ($value as $_key => $_value) {
				if (is_author($_value)) {
					$show = true;
					break;
				}
			}
		} else {
			$show = is_author($value);
		}

		return self::compare($show, true, $operator);
	}

	// Check current search query
	protected static function check_search_results($value, $operator)
	{
		$show = false;

		if (is_search()) {

			if (empty($value)) { // We're showing on all search pages

				$show = true;
			} else { // We're showing on specific keywords

				$phrase = get_search_query(); // The user search query

				if ('' !== $phrase && !empty($phrase)) { // Only proceed if there is a query

					$keywords = explode(',', $value); // Separate keywords

					foreach ($keywords as $index => $keyword) {
						if (self::keyword_exists(trim($keyword), $phrase)) {
							$show = true;
							break;
						}
					}
				}
			}
		}

		return self::compare($show, true, $operator);
	}

	// Check is EDD Cart is empty
	protected static function check_edd_cart($value, $operator)
	{

		if (!class_exists('Easy_Digital_Downloads', false))
			return false;

		$show = empty(edd_get_cart_contents());

		return self::compare($show, true, $operator);
	}

	protected static function keyword_exists($keyword, $phrase)
	{
		return strpos($phrase, trim($keyword)) !== false;
	}


	public static function get_instance()
	{
		if (!self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

JLTMA_Display_Conditions::get_instance();

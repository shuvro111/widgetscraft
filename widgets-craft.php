<?php
/**
 * Plugin Name: Widgets Craft
 * Description: Bunch of useful widgets for elementor page builder.
 * Plugin URI:  https://shuvrosarkar.com/
 * Version:     1.2.1
 * Author:      Shuvro Sarkar
 * Author URI:  https://shuvrosarkar.com/
 * Text Domain: widgets-craft
 *
 * Elementor tested up to: 3.13.0
 * Elementor Pro tested up to: 3.13.0
 */

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly

/**
 * Main Elementor Widgets Craft Class
 *
 * The init class that runs the Widgets Craft plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.2.0
 */


add_filter('plugin_row_meta', 'widgets_craft_plugin_row_meta', 10, 4);

function widgets_craft_plugin_row_meta($plugin_meta, $plugin_file, $plugin_data, $status)
{
	// Add "Settings" link
	$plugin_meta[] = '<a href="' . admin_url('admin.php?page=widgets-craft-settings') . '">' . __('Settings', 'widgets-craft') . '</a>';

	// Add "Upgrade to Pro" link
	$plugin_meta[] = '<a href="https://example.com/upgrade-to-pro" target="_blank">' . __('Upgrade to Pro', 'widgets-craft') . '</a>';

	return $plugin_meta;
}

// Add a link to the plugin action links
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'widgets_craft_action_links');

function widgets_craft_action_links($links)
{
	// Add "Settings" link
	$settings_link = '<a href="' . admin_url('admin.php?page=widgets-craft-settings') . '">' . __('Settings', 'widgets-craft') . '</a>';
	// Add "Star on GitHub" link
	$github_link = '<a href="https://github.com/shuvro-sarkar" target="_blank" style="color: #ffffff;font-weight: bold;background-color: #6646f5;padding: 5px 10px;border-radius: 3px;">' . __('Star on GitHub ★', 'my-awesome-plugin') . '</a>';

	array_push($links, $settings_link, $github_link);
	return $links;
}




// Add a menu item to the WordPress admin sidebar
add_action('admin_menu', 'widgets_craft_add_menu');

function widgets_craft_add_menu()
{
	add_menu_page(
		// Page title
		'Widgets Craft Settings',
		// Menu title
		'Widgets Craft',
		// Capability required to access the menu
		'manage_options',
		// Menu slug
		'widgets-craft-settings',
		// Callback function to render the settings page
		'widgets_craft_settings_page',
		// Icon URL or Dashicons class
		'dashicons-screenoptions',
		30 // Position in the menu
	);
}

// Callback function to render the settings page
function widgets_craft_settings_page()
{
	// Load Font Awesome
	wp_enqueue_style('font-awesome-core', 'http://localhost/dev/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.15.3');
	wp_enqueue_style('font-awesome', 'http://localhost/dev/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css?ver=5.15.3');

	// Enqueue external CSS file
	wp_enqueue_style('widgets-craft-settings-css', plugins_url('assets/css/settings.css', __FILE__));

	// Load Font Awesome JS

	// Enqueue external JS file
	wp_enqueue_script('widgets-craft-settings-js', plugins_url('assets/js/settings.js', __FILE__), array('jquery'), '1.0.0', true);

	// Render the settings template
	include_once(plugin_dir_path(__FILE__) . 'settings.php');
}



final class WidgetsCraft
{

	/**
	 * Plugin Version
	 *
	 * @since 1.2.1
	 * @var string The plugin version.
	 */
	const VERSION = '1.2.1';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.2.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct()
	{

		// Init Plugin
		add_action('plugins_loaded', array($this, 'init'));
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function init()
	{

		// Check if Elementor installed and activated
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', array($this, 'admin_notice_missing_main_plugin'));
			return;
		}

		// Check for required Elementor version
		if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
			return;
		}

		// Check for required PHP version
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', array($this, 'admin_notice_minimum_php_version'));
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once('plugin.php');
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin()
	{
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-hello-world'),
			'<strong>' . esc_html__('Elementor Hello World', 'elementor-hello-world') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'elementor-hello-world') . '</strong>'
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version()
	{
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-hello-world'),
			'<strong>' . esc_html__('Elementor Hello World', 'elementor-hello-world') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'elementor-hello-world') . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version()
	{
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-hello-world'),
			'<strong>' . esc_html__('Elementor Hello World', 'elementor-hello-world') . '</strong>',
			'<strong>' . esc_html__('PHP', 'elementor-hello-world') . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}
}

// Instantiate WidgetsCraft.
new WidgetsCraft();
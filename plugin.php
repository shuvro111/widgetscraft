<?php
namespace WidgetsCraft;

use ElementorHelloWorld\PageSettings\Page_Settings;

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly





/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin
{

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Load Editor Styles
	 * 
	 * @since 1.2.0
	 * 
	 * @access public
	 *	 
	 */

	public function editor_styles()
	{
		wp_enqueue_style('widgets-craft-editor-styles', plugins_url('assets/css/editor-styles.css', __FILE__));
	}
	public function editor_scripts()
	{
		wp_enqueue_style('widgets-craft-editor-scripts', plugins_url('assets/css/editor-script.js', __FILE__));
	}



	/**
	 * Force load editor script as a module
	 *
	 * @since 1.2.1
	 *
	 * @param string $tag
	 * @param string $handle
	 *
	 * @return string
	 */
	public function editor_scripts_as_a_module($tag, $handle)
	{
		if ('elementor-hello-world-editor' === $handle) {
			$tag = str_replace('<script', '<script type="module"', $tag);
		}

		return $tag;
	}

	/**
	 * Add Category -> WidgetsCraft
	 *
	 * Add new category to the Elementor widgets panel.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function add_widgetscraft_category($elements_manager)
	{
		$elements_manager->add_category(
			'widgets-craft',
			[
				'title' => esc_html__('Widgets Craft', 'widgets-craft'),
				'icon' => 'fas fa-wind',
			]
		);
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @param Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets($widgets_manager)
	{
		// Its is now safe to include Widgets files
		require_once(__DIR__ . '/widgets/donut-chart.php');
		require_once(__DIR__ . '/widgets/column-chart.php');
		require_once(__DIR__ . '/widgets/line-chart.php');
		require_once(__DIR__ . '/widgets/icon-button.php');

		// Register Widgets
		$widgets_manager->register(new Widgets\Donut_Chart());
		$widgets_manager->register(new Widgets\Column_Chart());
		$widgets_manager->register(new Widgets\Line_Chart());
	}

	/**
	 * Add page settings controls
	 *
	 * Register new settings for a document page settings.
	 *
	 * @since 1.2.1
	 * @access private
	 */
	private function add_page_settings_controls()
	{
		require_once(__DIR__ . '/page-settings/manager.php');
		new Page_Settings();
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct()
	{
		// Register category
		add_action('elementor/elements/categories_registered', [$this, 'add_widgetscraft_category']);

		// Register widgets
		add_action('elementor/widgets/register', [$this, 'register_widgets']);

		// Register editor scripts
		add_action('elementor/editor/after_enqueue_styles', [$this, 'editor_styles']);
		add_action('elementor/editor/after_enqueue_scripts', [$this, 'editor_scripts']);

		$this->add_page_settings_controls();
	}
}

// Instantiate Plugin Class
Plugin::instance();
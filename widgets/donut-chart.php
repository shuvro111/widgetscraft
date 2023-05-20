<?php
namespace WidgetsCraft\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Donut_Chart extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'donut-chart';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Donut Chart', 'widgets-craft' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Retrieve the list of styles the widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends() {
		return [ 'donut-chart' ];
	}
	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'donut-chart' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'widgets-craft' ),
			]
		);

		//repeater control with label and value
		$repeater = new \Elementor\Repeater();
		$repeater -> add_control(
			'label',
			[
				'label' => __( 'Label', 'widgets-craft' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Label', 'widgets-craft' ),
				'label_block' => true,
			]
		);
		$repeater -> add_control(
			'value',
			[
				'label' => __( 'Value', 'widgets-craft' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Value', 'widgets-craft' ),
				'label_block' => true,
			]
		);

		$this -> add_control(
			'list',
			[
				'label' => __( 'List', 'widgets-craft' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater -> get_controls(),
				'default' => [
					[
						'label' => __( 'Label #1', 'widgets-craft' ),
						'value' => __( 'Value #1', 'widgets-craft' ),
					],
					[
						'label' => __( 'Label #2', 'widgets-craft' ),
						'value' => __( 'Value #2', 'widgets-craft' ),
					],
					[
						'label' => __( 'Label #3', 'widgets-craft' ),
						'value' => __( 'Value #3', 'widgets-craft' ),
					],
				],
				'title_field' => '{{{ label }}}',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'widgets-craft' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
		<div class="chartdiv"></div> 
		<?php
	}
}

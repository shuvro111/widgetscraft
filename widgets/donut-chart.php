<?php

namespace WidgetsCraft\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Donut_Chart extends Widget_Base
{

	public function __construct($data = [], $args = null)
	{
		parent::__construct($data, $args);

		add_action('elementor/frontend/after_enqueue_scripts', [$this, 'widget_scripts']);
	}

	public function widget_scripts()
	{
		wp_enqueue_script('amcharts-core', 'https://cdn.amcharts.com/lib/4/core.js', ['jquery', 'elementor-frontend'], false, true);
		wp_enqueue_script('amcharts-charts', 'https://cdn.amcharts.com/lib/4/charts.js', ['jquery', 'elementor-frontend'], false, true);
		wp_enqueue_script('amcharts-3d', 'https://cdn.amcharts.com/lib/4/themes/animated.js', ['jquery', 'elementor-frontend'], false, true);
		wp_enqueue_script('donut-chart', plugins_url('/assets/js/donut-chart.js', __FILE__), ['jquery', 'elementor-frontend'], false, true);

		wp_register_style('donut-chart', plugins_url('/assets/css/donut-chart.css', __FILE__), [], false, 'all');
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
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
	public function get_title()
	{
		return __('Donut Chart', 'widgets-craft');
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
	public function get_icon()
	{
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
	public function get_categories()
	{
		return ['general'];
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
	public function get_style_depends()
	{
		return ['donut-chart'];
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
	public function get_script_depends()
	{
		return ['amcharts-core', 'amcharts-charts', 'amcharts-3d', 'donut-chart'];
	}

	protected function _register_controls()
	{
		$this->start_controls_section(
			'section_chart',
			[
				'label' => 'Chart Settings',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'label',
			[
				'label' => 'Label',
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Label',
			]
		);

		$repeater->add_control(
			'value',
			[
				'label' => 'Value',
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 0,
			]
		);

		$repeater->add_control(
			'color',
			[
				'label' => 'Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'chart_data',
			[
				'label' => 'Chart Data',
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'label' => 'Label 1',
						'value' => 50,
						'color' => '#ffffff',
					],
					[
						'label' => 'Label 2',
						'value' => 30,
						'color' => '#ffffff',
					],
					[
						'label' => 'Label 3',
						'value' => 20,
						'color' => '#ffffff',
					],
				],
				'title_field' => '{{{ label }}}',
			]
		);


		$this->add_control(
			'disable_legend_toggle',
			[
				'label' => 'Disable Legend Toggle',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => 'Yes',
				'label_off' => 'No',
				'return_value' => 'yes',
				'default' => 'no',
				'description' => 'Toggle the ability for users to click on the legend to hide/show data.',
			]
		);

		//label visibility toggle
		$this->add_control(
			'disable_label_toggle',
			[
				'label' => 'Disable Label Toggle',
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => 'Yes',
				'label_off' => 'No',
				'return_value' => 'yes',
				'default' => 'no',
				'description' => 'Toggle the ability for users to click on the label to hide/show data.',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_container_style',
			[
				'label' => 'Container Styles',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'chart_container_width',
			[
				'label' => 'Container Width',
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
					'em'
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'chart_container_height',
			[
				'label' => 'Container Height',
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
					'vh'
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'chart_container_padding',
			[
				'label' => 'Container Padding',
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
					'%',
					'em',
					'rem'
				],
				'selectors' => [
					'{{WRAPPER}} .chartdiv' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'chart_background_color',
			[
				'label' => 'Background Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .chartdiv' => 'background-color: {{VALUE}};',
				],
			]
		);

		// container border group control
		$this->start_controls_tabs(
			'chart_container_border_tabs'
		);

		$this->start_controls_tab(
			'chart_container_border_normal_tab',
			[
				'label' => 'Normal',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'chart_container_border',
				'label' => 'Border',
				'selector' => '{{WRAPPER}} .chartdiv',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'chart_container_box_shadow',
				'label' => 'Box Shadow',
				'selector' => '{{WRAPPER}} .chartdiv',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'chart_container_border_hover_tab',
			[
				'label' => 'Hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'chart_container_border_hover',
				'label' => 'Border',
				'selector' => '{{WRAPPER}} .chartdiv:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'chart_container_box_shadow_hover',
				'label' => 'Box Shadow',
				'selector' => '{{WRAPPER}} .chartdiv:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'chart_container_border_radius',
			[
				'label' => 'Border Radius',
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
					'%',
					'em',
					'rem'
				],
				'selectors' => [
					'{{WRAPPER}} .chartdiv' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);



		//typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'chart_label_typography',
				'label' => 'Label Typography',
				'selector' => '{{WRAPPER}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_chart_style',
			[
				'label' => 'Chart Options',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'chart_inner_radius',
			[
				'label' => 'Inner Radius',
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 100,
				'description' => 'Set the inner radius of the chart. 0 for pie, 100 for donut.',
				'responsive' => true,
			]
		);

		$this->add_control(
			'chart_depth_3d',
			[
				'label' => '3D Depth',
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 120,
				'description' => 'Set the 3D depth of the chart.',
				'responsive' => true,
			]
		);

		//size of the chart
		$this->add_control(
			'chart_size',
			[
				'label' => 'Chart Size',
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 100,
				'description' => 'Set the size of the chart.',
				'responsive' => true,
			]
		);

		// chart angle
		$this->add_control(
			'chart_angle',
			[
				'label' => 'Chart Angle',
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 0,
				'description' => 'Set the angle of the chart.',
				'responsive' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_chart_legend_style',
			[
				'label' => 'Chart Legend Style',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'chart_legend_position',
			[
				'label' => 'Legend Position',
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left' => 'Left',
					'right' => 'Right',
					'top' => 'Top',
					'bottom' => 'Bottom',
				]
			]
		);

		//legend marker width
		$this->add_control(
			'chart_legend_marker_size',
			[
				'label' => 'Legend Marker Size',
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 15,
				'description' => 'Set the size of the legend marker.',
				'responsive' => true,
			]
		);

		//legend border radius
		$this->add_control(
			'chart_legend_border_radius',
			[
				'label' => 'Legend Border Radius',
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
				],
			]
		);

		//value labels alignment
		$this->add_control(
			'chart_value_labels_align',
			[
				'label' => 'Value Labels Alignment',
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'left',
				'options' => [
					'left' => 'Left',
					'right' => 'Right',
				]
			]
		);

		//value labels text alignment
		$this->add_control(
			'chart_value_labels_text_align',
			[
				'label' => 'Value Labels Text Alignment',
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'end',
				'options' => [
					'start' => 'Start',
					'end' => 'End',
				]
			]
		);

		//Legend Padding
		$this->add_control(
			'chart_legend_padding',
			[
				'label' => 'Legend Padding',
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
				],
			]
		);



		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$chart_data = $settings['chart_data'];
		$chart_legend_position = $settings['chart_legend_position'];
		$disable_legend_toggle = $settings['disable_legend_toggle'];
		?>
		<div id="amcharts-chart-<?php echo $this->get_id(); ?>" class="amcharts-chart-<?php echo $this->get_id(); ?> chartdiv">
		</div>

		<script>
			jQuery(document).ready(function ($) {
				function loadAmCharts() {
					if (typeof am4core === 'undefined' || typeof am4charts === 'undefined') {
						setTimeout(loadAmCharts, 50);
					} else {
						createChart();
					}
				}

				function createChart() {
					am4core.ready(function () {
						var chartData = <?php echo wp_json_encode($chart_data); ?>;

						am4core.useTheme(am4themes_animated);
						var chart = am4core.create("amcharts-chart-<?php echo $this->get_id(); ?>", am4charts.PieChart3D);
						chart.hiddenState.properties.opacity = 0;

						chartData.forEach(function (data) {
							chart.data.push({
								label: data.label,
								value: data.value,
								color: am4core.color(data.color),
							});
						});

						chart.innerRadius = <?php echo $settings['chart_inner_radius']; ?>;
						chart.depth = <?php echo $settings['chart_depth_3d']; ?>;
						chart.radius = am4core.percent(<?php echo $settings['chart_size']; ?>);
						chart.angle = <?php echo $settings['chart_angle']; ?>;

						chart.legend = new am4charts.Legend();

						chart.legend.useDefaultMarker = true;

						if ('<?php echo $disable_legend_toggle; ?>' === 'yes') {
							chart.legend.itemContainers.template.clickable = false;
							chart.legend.itemContainers.template.focusable = false;
							chart.legend.itemContainers.template.cursorOverStyle = am4core.MouseCursorStyle.default;
						}


						chart.legend.position = '<?php echo $chart_legend_position; ?>';

						chart.legend.valueLabels.template.align = '<?php echo $settings['chart_value_labels_align']; ?>';
						chart.legend.valueLabels.template.textAlign = '<?php echo $settings['chart_value_labels_text_align']; ?>';


						chart.legend.itemContainers.template.paddingTop = '<?php echo $settings['chart_legend_padding']['top']; ?>';
						chart.legend.itemContainers.template.paddingBottom = '<?php echo $settings['chart_legend_padding']['bottom']; ?>';
						chart.legend.itemContainers.template.paddingLeft = '<?php echo $settings['chart_legend_padding']['left']; ?>';
						chart.legend.itemContainers.template.paddingRight = '<?php echo $settings['chart_legend_padding']['right']; ?>';


						let marker = chart.legend.markers.template.children.getIndex(0);
						var topCornerRadius = '<?php echo $settings['chart_legend_border_radius']['top'] ?>';
						var bottomCornerRadius = '<?php echo $settings['chart_legend_border_radius']['bottom'] ?>';
						var leftCornerRadius = '<?php echo $settings['chart_legend_border_radius']['left'] ?>';
						var rightCornerRadius = '<?php echo $settings['chart_legend_border_radius']['right'] ?>';
						marker.cornerRadius(topCornerRadius, rightCornerRadius, bottomCornerRadius, leftCornerRadius);
						chart.legend.markers.template.width = '<?php echo $settings['chart_legend_marker_size'] ?>';
						chart.legend.markers.template.height = '<?php echo $settings['chart_legend_marker_size'] ?>';



						var series = chart.series.push(new am4charts.PieSeries3D());
						series.dataFields.value = "value";
						series.dataFields.depthValue = "value";
						series.dataFields.category = "label";
						series.slices.template.cornerRadius = 5;
						series.colors.list = chartData.map(function (data) {
							return data.color;
						});

						if ('<?php echo $settings['label_visibility_toggle']; ?>' === 'yes') {
							series.labels.template.disabled = false;
						} else {
							series.labels.template.disabled = true;
						}

						series.slices.template.propertyFields.fill = "color";
					});
				}

				loadAmCharts();
			});
		</script>
		<?php
	}
}
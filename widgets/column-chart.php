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
class ColumnChart extends Widget_Base
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
        return 'column-chart';
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
        return __('Column Chart', 'widgets-craft');
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

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
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
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $chart_data = $settings['chart_data'];
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
                    var chartData = <?php echo wp_json_encode($chart_data); ?>;

                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("amcharts-chart-<?php echo $this->get_id(); ?>", am4charts.XYChart3D);
                    chart.hiddenState.properties.opacity = 0;

                    chartData.forEach(function (data) {
                        chart.data.push({
                            label: data.label,
                            value: data.value,
                            color: am4core.color(data.color),
                        });
                    });



                    console.log(chart.data);

                    // Create axes
                    let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.dataFields.category = "label";
                    categoryAxis.renderer.labels.template.rotation = 270;
                    categoryAxis.renderer.labels.template.hideOversized = false;
                    categoryAxis.renderer.minGridDistance = 20;
                    categoryAxis.renderer.labels.template.horizontalCenter = "right";
                    categoryAxis.renderer.labels.template.verticalCenter = "middle";
                    categoryAxis.tooltip.label.rotation = 270;
                    categoryAxis.tooltip.label.horizontalCenter = "right";
                    categoryAxis.tooltip.label.verticalCenter = "middle";

                    let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                    valueAxis.title.text = "Income";
                    valueAxis.title.fontWeight = "bold";

                    // Create series
                    var series = chart.series.push(new am4charts.ColumnSeries3D());
                    series.dataFields.valueY = "value";
                    series.dataFields.categoryX = "label";
                    series.name = "Visits";
                    series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
                    series.columns.template.fillOpacity = .8;

                    var columnTemplate = series.columns.template;
                    columnTemplate.strokeWidth = 2;
                    columnTemplate.strokeOpacity = 1;
                    columnTemplate.stroke = am4core.color("#FFFFFF");

                    columnTemplate.adapter.add("fill", function (fill, target) {
                        return chart.colors.getIndex(target.dataItem.index);
                    })

                    columnTemplate.adapter.add("stroke", function (stroke, target) {
                        return chart.colors.getIndex(target.dataItem.index);
                    })

                    chart.cursor = new am4charts.XYCursor();
                    chart.cursor.lineX.strokeOpacity = 0;
                    chart.cursor.lineY.strokeOpacity = 0;
                }
                loadAmCharts();
            });



        </script>
        <?php
    }
}
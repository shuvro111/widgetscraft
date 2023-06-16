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
class Line_Chart extends Widget_Base
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
        return 'line-chart';
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
        return __('Line Chart', 'widgets-craft');
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
        return 'fas fa-chart-line widgets-craft-widget-panel-icon';
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
        return ['widgets-craft'];
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
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // X Axis Title
        $this->add_control(
            'x_axis_title',
            [
                'label' => 'X Axis Title',
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'Enter X Axis Title',
            ]
        );

        // Y Axis Title
        $this->add_control(
            'y_axis_title',
            [
                'label' => 'Y Axis Title',
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'Enter Y Axis Title',
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
                    ],
                    [
                        'label' => 'Label 2',
                        'value' => 30,
                    ],
                    [
                        'label' => 'Label 3',
                        'value' => 20,
                    ],
                ],
                'title_field' => '{{{ label }}}',
            ]
        );


        //disable value tooltip
        $this->add_control(
            'disable_value_tooltip',
            [
                'label' => 'Disable Value Tooltip',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'Yes',
                'label_off' => 'No',
                'return_value' => 'yes',
                'default' => 'no',
                'description' => 'Toggle the ability for users to hover over the chart to see the value on the left.',
            ]
        );
        //disable category tooltip
        $this->add_control(
            'disable_category_tooltip',
            [
                'label' => 'Disable Category Tooltip',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'Yes',
                'label_off' => 'No',
                'return_value' => 'yes',
                'default' => 'no',
                'description' => 'Toggle the ability for users to hover over the chart to see the value on the right.',
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

        $this->end_controls_section();


        //chart styles section
        $this->start_controls_section(
            'chart_styles_section',
            [
                'label' => 'Chart Styles',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        //chart height
        $this->add_responsive_control(
            'chart_height',
            [
                'label' => 'Chart Height',
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
                    '{{WRAPPER}} .chartdiv' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Grid opacity
        $this->add_control(
            'chart_grid_opacity',
            [
                'label' => 'Grid Opacity',
                'description' => 'Grid opacity. Value range is 0 - 1.',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [
                    ''
                ],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'unit' => '',
                    'size' => 0.8,
                ],

            ]
        );

        // X Axis Label Rotation
        $this->add_control(
            'chart_x_axis_label_rotation',
            [
                'label' => 'X Axis Label Rotation',
                'description' => 'X axis label rotation angle. Valid values are from -360 to 360.',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [
                    ''
                ],
                'range' => [
                    '' => [
                        'min' => -360,
                        'max' => 360,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'unit' => '',
                    'size' => 0,
                ],

            ]
        );

        // Y Axis Label Rotation
        $this->add_control(
            'chart_y_axis_label_rotation',
            [
                'label' => 'Y Axis Label Rotation',
                'description' => 'Y axis label rotation angle. Valid values are from -360 to 360.',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [
                    ''
                ],
                'range' => [
                    '' => [
                        'min' => -360,
                        'max' => 360,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'unit' => '',
                    'size' => 0,
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

        //Section Line Chart Styles
        $this->start_controls_section(
            'section_line_chart_styles',
            [
                'label' => 'Line Chart Styles',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        //line_chart stroke color
        $this->add_control(
            'line_chart_stroke_color',
            [
                'label' => 'Stroke Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#67b7dc',
            ]
        );

        //line_chart stroke width
        $this->add_control(
            'line_chart_stroke_width',
            [
                'label' => 'Stroke Width',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [
                    'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
            ]
        );

        //line_chart bullet background color
        $this->add_control(
            'line_chart_bullet_background_color',
            [
                'label' => 'Bullet Background Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        //line_chart background color
        $this->add_control(
            'line_chart_background_color',
            [
                'label' => 'Background Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#67b7dc',
            ]
        );

        //line_chart background opacity
        $this->add_control(
            'line_chart_background_opacity',
            [
                'label' => 'Background Opacity',
                'description' => 'Background opacity. Value range is 0 - 1.',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [
                    ''
                ],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'unit' => '',
                    'size' => 0.8,
                ],

            ]
        );

        //line_chart smoothness
        $this->add_control(
            'line_chart_smoothness',
            [
                'label' => 'Smoothness',
                'description' => 'Tension of the line. 0 - no smoothing. 1 - very smooth.',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [
                    ''
                ],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1
                    ]
                ],
                'default' => [
                    'unit' => '',
                    'size' => 0.8,
                ],

            ]
        );


        $this->end_controls_section();

        //Section Tooltip Styles
        $this->start_controls_section(
            'section_tooltip_styles',
            [
                'label' => 'Tooltip Styles',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        //tooltip background color
        $this->add_control(
            'tooltip_background_color',
            [
                'label' => 'Background Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );

        //tooltip font color
        $this->add_control(
            'tooltip_text_color',
            [
                'label' => 'Font Color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
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
                    var chart = am4core.create("amcharts-chart-<?php echo $this->get_id(); ?>", am4charts.XYChart);
                    chart.hiddenState.properties.opacity = 0;


                    chartData.forEach(function (data) {
                        chart.data.push({
                            label: data.label,
                            value: data.value,
                        });
                    });




                    // Create axes
                    let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());


                    categoryAxis.title.text = '<?php echo $settings['x_axis_title']; ?>';
                    categoryAxis.title.fontWeight = "bold";
                    categoryAxis.dataFields.category = "label";
                    categoryAxis.renderer.labels.template.rotation = '<?php echo $settings['chart_x_axis_label_rotation']['size']; ?>';
                    categoryAxis.renderer.grid.template.location = 0;


                    //show all labels
                    categoryAxis.renderer.minGridDistance = 1;
                    categoryAxis.startLocation = 0;


                    // width and column spacing

                    valueAxis.renderer.labels.template.rotation = '<?php echo $settings['chart_y_axis_label_rotation']['size']; ?>';
                    valueAxis.renderer.grid.template.strokeOpacity = '<?php echo $settings['chart_grid_opacity']['size']; ?>';

                    valueAxis.title.text = '<?php echo $settings['y_axis_title']; ?>';
                    valueAxis.title.fontWeight = "bold";

                    // control category tooltip visibility
                    if ('<?php echo $settings['disable_category_tooltip']; ?>' === 'yes') {
                        categoryAxis.tooltip.disabled = true;
                    } else {
                        categoryAxis.tooltip.disabled = false;
                    }
                    // control value tooltip visibility
                    if ('<?php echo $settings['disable_value_tooltip']; ?>' === 'yes') {
                        valueAxis.tooltip.disabled = true;
                    } else {
                        valueAxis.tooltip.disabled = false;
                    }



                    // Create series
                    var series = chart.series.push(new am4charts.LineSeries());


                    series.dataFields.valueY = "value";
                    series.dataFields.categoryX = "label";

                    // Create a CircleBullet for the data points
                    var bullet = series.bullets.push(new am4charts.CircleBullet());
                    bullet.circle.radius = 4; // Set the radius of the circle bullet
                    bullet.circle.strokeWidth = 2; // Set the stroke width of the circle bullet


                    // Override the default state of the CircleBullet on hover
                    var hoverState = bullet.states.create("hover");
                    hoverState.properties.scale = 1.7;
                    hoverState.properties.hidden = false;


                    // Enable tooltips
                    series.tooltipText = `${categoryAxis.title.text}: [bold]{label}[/]\n${valueAxis.title.text}: [bold]{value}[/]`;

                    // Tooltip styling
                    series.tooltip.getFillFromObject = false;

                    // Tooltip background color
                    series.tooltip.background.fill = am4core.color('<?php echo $settings['tooltip_background_color']; ?>');

                    // Tooltip text color
                    series.tooltip.label.fill = am4core.color('<?php echo $settings['tooltip_text_color']; ?>');


                    // Line Chart Styling

                    //line_chart stroke color
                    series.stroke = am4core.color('<?php echo $settings['line_chart_stroke_color']; ?>');

                    //bullet background color
                    series.fill = am4core.color('<?php echo $settings['line_chart_background_color']; ?>');
                    series.fillOpacity = '<?php echo $settings['line_chart_background_opacity']['size']; ?>';

                    //line_chart stroke width
                    series.strokeWidth = '<?php echo $settings['line_chart_stroke_width']['size']; ?>';

                    //line_chart smoothness
                    series.tensionX = '<?php echo $settings['line_chart_smoothness']['size']; ?>';





                    // Enable/Disable cursor
                    chart.cursor = new am4charts.XYCursor();

                    // Enable/Disable scrollbar
                    chart.scrollbarX = new am4core.Scrollbar();

                }
                loadAmCharts();
            });



        </script>
        <?php
    }
}

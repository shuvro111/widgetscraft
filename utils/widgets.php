<?php

namespace WidgetsCraft\Config;

defined('ABSPATH') || exit; // Exit if accessed directly

class Widgets_List
{
    public function get_widget_craft_widgets()
    {
        return array(
            // Column Chart

            'column-chart' => array(
                'slug' => 'column-chart',
                'icon' => 'fas fa-chart-bar',
                'title' => 'Column Chart',
                'description' => 'An advanced column chart widget for Elementor.',
                'package' => 'free',
                // free, pro, free
                //'path' => 'path to the widget directory',
                //'base_class_name' => 'main class name',
                //'title' => 'widget title',
                //'live' => 'live demo url'
                'widget-category' => 'general',
                // General
            ),

            // Donut Chart
            'donut-chart' => array(
                'slug' => 'donut-chart',
                'icon' => 'fas fa-chart-pie',
                'title' => 'Donut Chart',
                'description' => 'An advanced donut chart widget for Elementor.',
                'package' => 'free',
                'widget-category' => 'general',
            ),

            // Advanced Accordion
            'advanced-accordion' => array(
                'slug' => 'advanced-accordion',
                'icon' => 'eicon-accordion',
                'title' => 'Advanced Accordion',
                'description' => 'An advanced accordion widget for Elementor.',
                'package' => 'free',
                'widget-category' => 'general',
            ),
        );
    }
}
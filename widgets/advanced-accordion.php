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
class Advanced_Accordion extends Widget_Base
{

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
        return 'advanced-accordion';
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
        return __('Advanced Accordion', 'widgets-craft');
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
        return 'eicon-accordion widgets-craft-widget-panel-icon';
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
        return ['advanced-accordion'];
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
        return ['advanced-accordion'];
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
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_accordion',
            [
                'label' => 'Accordion',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => 'Title',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Accordion Item',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => 'Content',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => 'Accordion content',
                'show_label' => false,
            ]
        );

        $this->add_control(
            'accordion_items',
            [
                'label' => 'Accordion Items',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ title }}}',
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
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['accordion_items'])) {
            return;
        }

        echo '<div class="accordion">';

        foreach ($settings['accordion_items'] as $item) {
            ?>
            <div class="accordion">
                <div class="accordion-item">
                    <h3 class="accordion-title">
                        <h3 class="accordion-title">
                            <?= $item['title'] ?>
                        </h3>
                        <span class="accordion-icon-opened"></span>
                        <span class="accordion-icon-closed"></span>
                    </h3>
                    <div class="accordion-content">
                        <div class="accordion-content">
                            <?= $item['content'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        echo '</div>';
    }


    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    /*     protected function content_template()
        {
            ?>
                    <div class="title">
                        {{{ settings.title }}}
                    </div>
                    <?php
        } */
}
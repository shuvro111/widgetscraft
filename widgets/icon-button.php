<?php
namespace WidgetsCraft\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * WidgetsCraft widget.
 *
 * Elementor widget that displays an advanced accordion.
 *
 * @since 1.0.0
 */
class Icon_Button extends Widget_Base
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
        return 'icon-button';
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
        return __('Icon Button', 'widgets-craft');
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
        return 'eicon-button widgets-craft-widget-panel-icon';
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
        return ['icon-button'];
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
            'section_content',
            [
                'label' => __('Content', 'widgets-craft'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'widgets-craft'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Learn More', 'widgets-craft'),
                'label_block' => true,
                'placeholder' => __('Enter your title', 'widgets-craft'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __('Link', 'widgets-craft'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'widgets-craft'),
                'default' => [
                    'url' => '#',
                ],
                'show_external' => true,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'widgets-craft'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'angle-right',
                        'chevron-right',
                        'arrow-right',
                        'long-arrow-alt-right',
                        'paper-plane'
                    ],
                    'fa-regular' => [
                        'arrow-right',
                        'hand-point-right',
                        'caret-right',
                        'caret-square-right',
                        'paper-plane'
                    ],
                ],
                'skin' => 'inline',
                'label_block' => false,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __('Button', 'widgets-craft'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs('tabs_button_style');


        // Button Background Normal & Hover

        //add controls tab normal
        $this->start_controls_tab('tab_button_background_normal', ['label' => __('Normal', 'widgets-craft')]);

        // Button Background Normal
        $this->add_control('button_background_normal', [
            'label' => __('Background Color', 'widgets-craft'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .widgets-craft-icon-button .link::before' => 'background-color: {{VALUE}}',
            ],
        ]);


        // Button Border Normal
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border_normal',
                'label' => __('Border', 'widgets-craft'),
                'selector' => '{{WRAPPER}} .widgets-craft-icon-button .link::before',
            ]
        );

        // Button Border Radius Normal
        $this->add_responsive_control(
            'button_border_radius_normal',
            [
                'label' => __('Border Radius', 'widgets-craft'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button Box Shadow Normal
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow_normal',
                'label' => __('Box Shadow', 'widgets-craft'),
                'selector' => '{{WRAPPER}} .widgets-craft-icon-button .link::before',
            ]
        );


        $this->end_controls_tab();


        //add controls tab hover
        $this->start_controls_tab('tab_button_background_hover', ['label' => __('Hover', 'widgets-craft')]);

        // Button Background Hover
        $this->add_control('button_background_hover', [
            'label' => __('Background Color', 'widgets-craft'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .widgets-craft-icon-button .link:hover::before' => 'background-color: {{VALUE}}',
            ],
        ]);

        // Button Border Hover
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => __('Border', 'widgets-craft'),
                'selector' => '{{WRAPPER}} .widgets-craft-icon-button .link:hover::before',
            ]
        );

        // Button Border Radius Hover
        $this->add_responsive_control(
            'button_border_radius_hover',
            [
                'label' => __('Border Radius', 'widgets-craft'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link:hover::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button Box Shadow Hover
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow_hover',
                'label' => __('Box Shadow', 'widgets-craft'),
                'selector' => '{{WRAPPER}} .widgets-craft-icon-button .link:hover::before',
            ]
        );

        $this->end_controls_tab();


        $this->end_controls_tabs();


        // Button Height
        $this->add_responsive_control(
            'button_height',
            [
                'label' => __('Height', 'widgets-craft'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Button Padding
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'widgets-craft'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();



        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Text Style', 'widgets-craft'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Text Color Normal & Hover

        $this->start_controls_tabs('tabs_text_color_style');


        //add controls tab normal
        $this->start_controls_tab('tab_text_color_normal', ['label' => __('Normal', 'widgets-craft')]);

        // Text Color Normal
        $this->add_control('text_color_normal', [
            'label' => __('Text Color', 'widgets-craft'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .widgets-craft-icon-button .link .text' => 'color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();


        //add controls tab hover
        $this->start_controls_tab('tab_text_color_hover', ['label' => __('Hover', 'widgets-craft')]);

        // Text Color Hover
        $this->add_control('text_color_hover', [
            'label' => __('Text Color', 'widgets-craft'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .widgets-craft-icon-button .link:hover .text' => 'color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();


        $this->end_controls_tabs();



        // Text Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => __('Typography', 'widgets-craft'),
                'selector' => '{{WRAPPER}} .widgets-craft-icon-button .link .text',
            ]
        );

        // Text Spacing
        $this->add_responsive_control(
            'text_spacing',
            [
                'label' => __('Spacing', 'widgets-craft'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => -10,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link .text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Text Alignment
        $this->add_responsive_control(
            'text_alignment',
            [
                'label' => __('Alignment', 'widgets-craft'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'widgets-craft'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'widgets-craft'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'widgets-craft'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link .text' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        // Icon Style
        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __('Icon Style', 'widgets-craft'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_icon_style');

        // Icon Color Normal & Hover

        //add controls tab normal

        $this->start_controls_tab('tab_icon_color_normal', ['label' => __('Normal', 'widgets-craft')]);

        // Icon Color Normal

        $this->add_control('icon_color_normal', [
            'label' => __('Icon Color', 'widgets-craft'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .widgets-craft-icon-button .link .icon' => 'color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();


        //add controls tab hover

        $this->start_controls_tab('tab_icon_color_hover', ['label' => __('Hover', 'widgets-craft')]);

        // Icon Color Hover

        $this->add_control('icon_color_hover', [
            'label' => __('Icon Color', 'widgets-craft'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .widgets-craft-icon-button .link:hover .icon' => 'color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();


        $this->end_controls_tabs();

        // Icon Size

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Size', 'widgets-craft'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Icon Spacing

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => __('Spacing', 'widgets-craft'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => -10,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link .icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Hover Transform Controls

        $this->start_controls_section(
            'section_transform_style',
            [
                'label' => __('Hover Transform Controls', 'widgets-craft'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Icon Translate X

        $this->add_responsive_control(
            'icon_translate_x',
            [
                'label' => __('Icon Translate X', 'widgets-craft'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link:hover .icon' => 'transform: translateX({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        // Icon Translate Y

        $this->add_responsive_control(
            'icon_translate_y',
            [
                'label' => __('Icon Translate Y', 'widgets-craft'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link:hover .icon' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        // Title Translate X

        $this->add_responsive_control(
            'title_translate_x',
            [
                'label' => __('Title Translate X', 'widgets-craft'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link:hover .text' => 'transform: translateX({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        // Title Translate Y

        $this->add_responsive_control(
            'title_translate_y',
            [
                'label' => __('Title Translate Y', 'widgets-craft'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widgets-craft-icon-button .link:hover .text' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );
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
        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('link', $settings['link']);
        }

        ?>
        <div class="widgets-craft-icon-button">
            <a <?php echo $this->get_render_attribute_string('link'); ?> class="link">
                <span class="text">
                    <?php echo $settings['title'] ?>
                </span>
                <span class="icon">
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                </span>
            </a>
        </div>
        <?php
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
    protected function content_template()
    {
        ?>
        <# var iconHTML=elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden' : true }, 'i' , 'object' ); #>
            <div class="widgets-craft-icon-button">
                <a href="{{ settings.link.url }}" class="link">
                    <span class="text">
                        {{{ settings.title }}}
                    </span>
                    <span class="icon">
                        {{{ iconHTML.value }}}
                    </span>
                </a>
            </div>
            <?php
    }
}
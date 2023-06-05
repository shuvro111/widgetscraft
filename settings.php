<?php
namespace WidgetsCraft;

use WidgetsCraft\Config\Widgets_List;

require_once(__DIR__ . '/utils/widgets.php');



$widgets_list = new Widgets_List();

$widgets = $widgets_list->get_widget_craft_widgets();

?>

<div id="widgets-craft-settings">
    <header class="header">
        <div class="header-content responsive-wrapper">
            <div class="header-logo">
                <a href="#">
                    <div>
                        <img src="https://assets.codepen.io/285131/untitled-ui-icon.svg" />
                    </div>
                    <h1 class="logo">Widgets Craft</h1>
                </a>
            </div>
            <div class="header-navigation">
                <nav class="header-navigation-links">
                    <a href="#"> Home </a>
                    <a href="#"> Dashboard </a>
                    <a href="#"> Projects </a>
                    <a href="#"> Tasks </a>
                    <a href="#"> Reporting </a>
                    <a href="#"> Users </a>
                </nav>
                <div class="header-navigation-actions">
                    <a href="#" class="button">
                        <i class="ph-lightning-bold"></i>
                        <span>Upgrade now</span>
                    </a>

                </div>
            </div>
        </div>
    </header>
    <main class="main">
        <div class="responsive-wrapper">
            <div class="main-header">
                <h1>Settings</h1>
                <div class="search">
                    <input type="text" placeholder="Search" />
                    <button type="submit">
                        <i class="ph-magnifying-glass-bold"></i>
                    </button>
                </div>
            </div>
            <div class="horizontal-tabs">
                <a href="#">My details</a>
                <a href="#">Profile</a>
                <a href="#">Password</a>
                <a href="#">Team</a>
                <a href="#">Plan</a>
                <a href="#">Billing</a>
                <a href="#">Email</a>
                <a href="#">Notifications</a>
                <a href="#" class="active">Integrations</a>
                <a href="#">API</a>
            </div>
            <div class="content-header">
                <div class="content-header-intro">
                    <h2>Intergrations and connected apps</h2>
                    <p>Supercharge your workflow and connect the tool you use every day.</p>
                </div>
                <div class="content-header-actions">
                    <a href="#" class="button">
                        <i class="ph-faders-bold"></i>
                        <span>Filters</span>
                    </a>
                    <a href="#" class="button">
                        <i class="ph-plus-bold"></i>
                        <span>Request integration</span>
                    </a>
                </div>
            </div>
            <div class="content">
                <div class="content-panel">
                    <div class="vertical-tabs">
                        <a href="#" class="active">View all</a>
                        <a href="#">Developer tools</a>
                        <a href="#">Communication</a>
                        <a href="#">Productivity</a>
                        <a href="#">Browser tools</a>
                        <a href="#">Marketplace</a>
                    </div>
                </div>
                <div class="content-main">
                    <div class="card-grid">
                        <?php
                        foreach ($widgets as $widget) {
                            $widget_slug = $widget['slug'];
                            $widget_icon = $widget['icon'];
                            $widget_title = $widget['title'];
                            $widget_description = $widget['description'];
                            $widget_package = $widget['package'];
                            $widget_category = $widget['widget-category'];

                            // Output the combined HTML string using a single echo statement
                            echo '
                                <article class="card">
                                    <div class="card-header">
                                        <i class="' . $widget_icon . '"></i>
                                        <label class="toggle">
                                            <input type="checkbox" checked>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="card-body">
                                        <h3>' . $widget_title . '</h3>
                                        <p>' . $widget_description . '</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="#">View integration</a>
                                    </div>
                                </article>
                            ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
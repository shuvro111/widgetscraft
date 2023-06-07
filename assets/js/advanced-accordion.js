(function ($) {
    var AccordionHandler = function ($scope, $) {
        $(".accordion-title").click(function () {
            const item = $(this).parent();
            const content = item.find(".accordion-content");
            const iconOpened = item.find(".accordion-icon-opened");
            const iconClosed = item.find(".accordion-icon-closed");

            // Collapse other items
            $(".accordion-item").not(item).removeClass("active");
            $(".accordion-content").not(content).slideUp();
            $(".accordion-icon-opened").not(iconOpened).removeClass("icon-opened");
            $(".accordion-icon-closed").not(iconClosed).removeClass("icon-closed");

            // Toggle current item
            item.toggleClass("active");
            content.slideToggle();
            iconOpened.toggleClass("icon-opened");
            iconClosed.toggleClass("icon-closed");
        });

    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/advanced-accordion.default', AccordionHandler);
    });
})(jQuery);

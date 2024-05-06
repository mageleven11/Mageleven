define([
    'jquery',
    'Mageleven_SlickCarousel/js/slick'
], function ($) {
    'use strict';

    /**
     * Allows to wrap any content into
     *
     * <div data-mage-init='{"slickwrapper": {"el": ".product-items", ...}}'>
     *     {{widget type="Mageleven\Highlight\Block\ProductList\All" template="product/widget/content/grid.phtml"}}
     * </div>
     *
     * Slick carousel will be created on child `el` element with all received options.
     *
     * This wrapper is usefull, when you'd like to create click carousel on a
     * dynamically generated content (product listings, etc), and there is no
     * possibility to add `data-mage-init` property to slides parent element.
     *
     * @param  {Object} options
     * @param  {Element} el
     */
    $.fn.slickwrapper = function (options, el) {
        options = $.extend({
            rows: 0
        }, options);
        el = el || this;

        if (options.el) {
            $(el).find(options.el).slick(options);
        } else {
            $(el).slick(options);
        }

        return this;
    };

    return $.fn.slickwrapper;
});

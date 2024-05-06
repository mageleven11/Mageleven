/**
 * Mageleven
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageleven.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageleven.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageleven
 * @package     Mageleven_BannerSlider
 * @copyright   Copyright (c) Mageleven (https://www.mageleven.com/)
 * @license     https://www.mageleven.com/LICENSE.txt
 */

define([
    'Magento_Ui/js/grid/columns/thumbnail',
    'jquery',
    'mage/template',
    'text!Mageleven_BannerSlider/template/grid/cells/preview.html',
    'Magento_Ui/js/modal/modal',
    'mage/translate'
], function (Thumbnail, $, mageTemplate, previewTemplate) {
    'use strict';

    return Thumbnail.extend({
        defaults: {
            bodyTmpl: 'Mageleven_BannerSlider/grid/cells/html',
            fieldClass: {
                'data-grid-thumbnail-cell': true
            }
        },

        /**
         * Get content data per row
         * @param {Object} row
         * @returns {String}
         */
        getContent: function (row) {
            return row[this.index];
        },

        /**
         * Check banner type per row
         *
         * @param {Object} row
         * @returns {boolean}
         */
        getType: function (row) {
            return row[this.index + '_type'] === '1';
        },

        /**
         * Build preview.
         *
         * @param {Object} row
         */
        preview: function (row) {
            var modalHtml = mageTemplate(
                previewTemplate,
                {
                    src: this.getSrc(row), alt: this.getAlt(row), link: this.getLink(row), type: this.getType(row),
                    linkText: $.mage.__('Go to Details Page')
                }
                ),
                previewPopup = $('<div/>').html(modalHtml);

            previewPopup.modal({
                innerScroll: true,
                modalClass: '_image-box',
                buttons: []
            }).trigger('openModal');

            if (this.getType(row)) {
                $('.content-preview-block').html($.parseHTML(this.getContent(row)));
            }
        }
    });
});

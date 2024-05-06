/**
 * Mageleven
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the mageleven.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageleven.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageleven
 * @package     Mageleven_Core
 * @copyright   Copyright (c) Mageleven (https://www.mageleven.com/)
 * @license     https://www.mageleven.com/LICENSE.txt
 */

var config = {
    paths: {
        'mageleven/core/jquery/popup': 'Mageleven_Core/js/jquery.magnific-popup.min',
        'mageleven/core/owl.carousel': 'Mageleven_Core/js/owl.carousel.min',
        'mageleven/core/bootstrap': 'Mageleven_Core/js/bootstrap.min',
        mpIonRangeSlider: 'Mageleven_Core/js/ion.rangeSlider.min',
        touchPunch: 'Mageleven_Core/js/jquery.ui.touch-punch.min',
        mpDevbridgeAutocomplete: 'Mageleven_Core/js/jquery.autocomplete.min'
    },
    shim: {
        "mageleven/core/jquery/popup": ["jquery"],
        "mageleven/core/owl.carousel": ["jquery"],
        "mageleven/core/bootstrap": ["jquery"],
        mpIonRangeSlider: ["jquery"],
        mpDevbridgeAutocomplete: ["jquery"],
        touchPunch: ['jquery', 'jquery/ui']
    }
};

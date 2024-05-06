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
 * @category  Mageleven
 * @package   Mageleven_SocialLogin
 * @copyright Copyright (c) Mageleven (https://www.mageleven.com/)
 * @license   https://www.mageleven.com/LICENSE.txt
 */

var config = {
    paths: {
        socialProvider: 'Mageleven_SocialLogin/js/provider',
        socialPopupForm: 'Mageleven_SocialLogin/js/popup'
    },
    map: {
        '*': {
            'Magento_Checkout/js/proceed-to-checkout': 'Mageleven_SocialLogin/js/proceed-to-checkout'
        }
    }
};

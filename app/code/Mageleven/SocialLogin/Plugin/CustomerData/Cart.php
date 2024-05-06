<?php
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

namespace Mageleven\SocialLogin\Plugin\CustomerData;

use Magento\Checkout\CustomerData\Cart as CustomerCart;
use Mageleven\SocialLogin\Helper\Data as HelperData;

/**
 * Class Cart
 *
 * @package Mageleven\SocialLogin\Plugin\CustomerData
 */
class Cart
{
    /**
     * @var HelperData
     */
    protected $_helperData;

    /**
     * Cart constructor.
     *
     * @param HelperData $helperData
     */
    public function __construct(HelperData $helperData)
    {
        $this->_helperData = $helperData;
    }

    /**
     * @param CustomerCart $subject
     * @param $result
     *
     * @return mixed
     */
    public function afterGetSectionData(CustomerCart $subject, $result)
    {
        if ($this->_helperData->isEnabled() && $this->_helperData->isReplaceAuthModal()) {
            $result['isReplaceAuthModal'] = $this->_helperData->isReplaceAuthModal();
        }

        return $result;
    }
}

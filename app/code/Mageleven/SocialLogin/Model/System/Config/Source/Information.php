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

namespace Mageleven\SocialLogin\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Information
 *
 * @package Mageleven\SocialLogin\Model\System\Config\Source
 */
class Information implements ArrayInterface
{
    const INFO_EMAIL = 'email';
    const INFOR_NAME = 'name';
    const INFOR_PW   = 'password';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::INFO_EMAIL, 'label' => __('Email')],
            ['value' => self::INFOR_NAME, 'label' => __('Name')],
            ['value' => self::INFOR_PW, 'label' => __('Password')]
        ];
    }
}

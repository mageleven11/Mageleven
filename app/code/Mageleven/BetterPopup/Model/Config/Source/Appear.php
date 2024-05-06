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
 * @category    Mageleven
 * @package     Mageleven_BetterPopup
 * @copyright   Copyright (c) Mageleven (https://www.mageleven.com/)
 * @license     https://www.mageleven.com/LICENSE.txt
 */

namespace Mageleven\BetterPopup\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Appear
 * @package Mageleven\BetterPopup\Model\Config\Source
 */
class Appear implements ArrayInterface
{
    const EXIT_INTENT = 1;
    const AFTER_PAGE_LOADED = 2;
    const AFTER_X_SECONDS = 3;
    const AFTER_SCROLL_DOWN = 4;

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::EXIT_INTENT, 'label' => __('Exit Intent')],
            ['value' => self::AFTER_PAGE_LOADED, 'label' => __('After page loaded')],
            ['value' => self::AFTER_X_SECONDS, 'label' => __('After X seconds')],
            ['value' => self::AFTER_SCROLL_DOWN, 'label' => __('After scrolling down X% of page')],
        ];
    }
}

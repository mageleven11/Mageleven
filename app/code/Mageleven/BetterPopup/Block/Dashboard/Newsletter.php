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

namespace Mageleven\BetterPopup\Block\Dashboard;

use Magento\Framework\Phrase;
use Mageleven\BetterPopup\Block\Subscriber;

/**
 * Class Newsletter
 * @package Mageleven\BetterPopup\Block\Dashboard
 */
class Newsletter extends Subscriber
{
    /**
     * path of template
     */
    protected $_template = 'dashboard/newsletter.phtml';

    /**
     * @return Phrase|string
     */
    public function getTitle()
    {
        return __('Subscribers');
    }
}

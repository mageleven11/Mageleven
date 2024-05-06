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

namespace Mageleven\BetterPopup\Block\Email;

use Mageleven\BetterPopup\Block\Subscriber;

/**
 * Class Template
 * @package Mageleven\BetterPopup\Block\Email
 */
class Template extends Subscriber
{
    /**
     * Get list email subscribers in the week
     *
     * @return array
     */
    public function getListEmailSubscriberWeek()
    {
        $listEmail = [];
        $subscribersCollection = $this->getSubscriberInWeek($this->_helperData->getStoreId());
        foreach ($subscribersCollection as $item) {
            $listEmail[] = $item->getData('subscriber_email');
        }

        return $listEmail;
    }

    /**
     * Get Format Current time (title email)
     *
     * @return false|string
     */
    public function getCurrentTime()
    {
        $date = $this->_getDayDate->gmtDate('Y-M-d');

        return date('d M Y', strtotime($date));
    }
}

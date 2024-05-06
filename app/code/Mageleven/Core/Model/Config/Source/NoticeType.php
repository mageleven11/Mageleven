<?php
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

namespace Mageleven\Core\Model\Config\Source;

/**
 * Class NoticeType
 * @package Mageleven\Core\Model\Config\Source
 */
class NoticeType extends AbstractSource
{
    const TYPE_ANNOUNCEMENT = 'announcement';
    const TYPE_NEWUPDATE    = 'new_update';
    const TYPE_MARKETING    = 'marketing';

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::TYPE_ANNOUNCEMENT => __('Announcement'),
            self::TYPE_NEWUPDATE    => __('New & Update extensions'),
            self::TYPE_MARKETING    => __('Promotions ')
        ];
    }
}

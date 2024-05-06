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

namespace Mageleven\Core\Plugin;

use Magento\Backend\Model\Menu\Builder\AbstractCommand;
use Mageleven\Core\Helper\AbstractData;

/**
 * Class MoveMenu
 * @package Mageleven\Core\Plugin
 */
class MoveMenu
{
    const MAGELEVEN_CORE = 'Mageleven_Core::menu';

    /**
     * @var AbstractData
     */
    protected $helper;

    /**
     * MoveMenu constructor.
     *
     * @param AbstractData $helper
     */
    public function __construct(AbstractData $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param AbstractCommand $subject
     * @param $itemParams
     *
     * @return mixed
     */
    public function afterExecute(AbstractCommand $subject, $itemParams)
    {
        if ($this->helper->getConfigGeneral('menu')) {
            if (strpos($itemParams['id'], 'Mageleven_') !== false
                && isset($itemParams['parent'])
                && strpos($itemParams['parent'], 'Mageleven_') === false) {
                $itemParams['parent'] = self::MAGELEVEN_CORE;
            }
        } elseif ((isset($itemParams['id']) && $itemParams['id'] === self::MAGELEVEN_CORE)
                || (isset($itemParams['parent']) && $itemParams['parent'] === self::MAGELEVEN_CORE)) {
            $itemParams['removed'] = true;
        }

        return $itemParams;
    }
}

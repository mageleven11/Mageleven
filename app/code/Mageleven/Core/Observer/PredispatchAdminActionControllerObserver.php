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

namespace Mageleven\Core\Observer;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mageleven\Core\Helper\AbstractData;
use Mageleven\Core\Model\Feed;

/**
 * Class PredispatchAdminActionControllerObserver
 * @package Mageleven\Core\Observer
 */
class PredispatchAdminActionControllerObserver implements ObserverInterface
{
    /**
     * @type Session
     */
    protected $_backendAuthSession;

    /**
     * @var AbstractData
     */
    protected $helper;

    /**
     * PredispatchAdminActionControllerObserver constructor.
     *
     * @param Session $backendAuthSession
     * @param AbstractData $helper
     */
    public function __construct(
        Session $backendAuthSession,
        AbstractData $helper
    ) {
        $this->_backendAuthSession = $backendAuthSession;
        $this->helper = $helper;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->_backendAuthSession->isLoggedIn()
            && $this->helper->isModuleOutputEnabled('Magento_AdminNotification')) {
            /* @var $feedModel Feed */
            $feedModel = $this->helper->createObject(Feed::class);
            $feedModel->checkUpdate();
        }
    }
}

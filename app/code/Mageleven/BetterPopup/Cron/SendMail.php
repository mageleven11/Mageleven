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

namespace Mageleven\BetterPopup\Cron;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Store\Model\StoreManagerInterface;
use Mageleven\BetterPopup\Controller\Adminhtml\Send\Send;
use Mageleven\BetterPopup\Helper\Data;

/**
 * Class SendMail
 * @package Mageleven\BetterPopup\Cron
 */
class SendMail
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var Data
     */
    protected $_helperData;

    /**
     * @var Send
     */
    protected $_send;

    /**
     * SendMail constructor.
     *
     * @param Data $helperData
     * @param Send $send
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Data $helperData,
        Send $send,
        StoreManagerInterface $storeManager
    ) {
        $this->_helperData = $helperData;
        $this->_send = $send;
        $this->_storeManager = $storeManager;
    }

    /**
     * @throws LocalizedException
     * @throws MailException
     */
    public function execute()
    {
        foreach ($this->_storeManager->getStores() as $store) {
            if ($this->_helperData->isEnabled($store->getId()) && $this->_helperData->isSendEmail($store->getId())) {
                $this->_send->sendMail($store);
            }
        }
    }
}

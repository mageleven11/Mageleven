<?php
/**
 * Magezon
 *
 * This source file is subject to the Magezon Software License, which is available at http://magezon.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magezon.com for more information.
 *
 * @category  Magezon
 * @package   Magezon_CustomerApproval
 * @copyright Copyright (C) 2021 Magezon (http://magezon.com)
 */

namespace Magezon\CustomerApproval\Model;

use Magento\Contact\Model\ConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\User\Model\ResourceModel\User\CollectionFactory;
use Magezon\CustomerApproval\Helper\Data;
use Magezon\CustomerApproval\Model\Attribute\Source\ListStatus;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Contact\Model\ConfigInterface
     */
    protected $contactsConfig;

    /**
     * @var \Magento\Framework\Escaper
     */
    protected $transportBuilder;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $storeManager;

    /**
     * @var \Magezon\CustomerApproval\Helper\Data
     */
    protected $dataHelper;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * [__construct description]
     * @param Context $context
     * @param ConfigInterface $contactsConfig
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $collectionFactory
     * @param Data $dataHelper
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Contact\Model\ConfigInterface $contactsConfig,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\User\Model\ResourceModel\User\CollectionFactory $collectionFactory,
        \Magezon\CustomerApproval\Helper\Data $dataHelper
    ) {
        parent::__construct($context);
        $this->contactsConfig = $contactsConfig;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->collectionFactory = $collectionFactory;
        $this->dataHelper = $dataHelper;
    }

    /**
     * Send Email Template action
     * @param $templateId
     * @param $toEmail
     */
    public function sendEmailToCustomer($type, $email, $customer)
    {
        switch ($type) {
            case ListStatus::STATUS_REJECTED:
                $templateId = $this->dataHelper->getEmailTemplateRejected();
                break;
            case ListStatus::STATUS_APPROVED:
                $templateId = $this->dataHelper->getEmailTemplateApproval();
                break;
            default:
                $templateId = $this->dataHelper->getEmailTemplatePending();
                break;
        }
        $storeId = $this->getStore()->getId();

        $this->sendEmailByTemplate(
            $email,
            $templateId,
            [
                'name' =>  $customer->getName(),
                'email' => $customer->getEmail(),
                'store' => $this->getStore()
            ],
            $storeId,
            false
        );

        return $this;
    }

    /**
     * Send Email Template action
     * @param $templateId
     * @param $toEmail
     */
    public function sendEmailToAdmin($customerEmail, $name)
    {
        $templateId = $this->dataHelper->getEmailTemplateAdmin();
        $storeId = $this->getStore()->getId();
        $this->sendEmailByTemplate(
            $customerEmail,
            $templateId,
            [
                'name' => $name,
                'customer_email' => $customerEmail,
                'store' => $this->getStore()
            ],
            $storeId,
            true
        );
        return $this;
    }

    /**
     * Send Email Template action
     * @param $email
     * @param $templateId
     * @param array $param
     * @param null $storeId
     * @param bool $isAdmin
     * @throws LocalizedException
     * @throws MailException
     */
    public function sendEmailByTemplate($email, $templateId, $param = [], $storeId = null, $isAdmin = false)
    {
        $emailSender = $isAdmin ? $this->dataHelper->getEmailAdminSender() : $this->dataHelper->getEmailCustomerSender();
        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $storeId,
        ];
        $transport = $this->transportBuilder->setTemplateIdentifier($templateId)
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($param)
            ->setFrom($emailSender)
            ->addTo($email)
            ->getTransport();
        $transport->sendMessage();
    }

    /**
     * get store name
     *
     * @return mixed
     */
    public function getStore()
    {
        $store = $this->storeManager->getStore();
        return $store;
    }
}

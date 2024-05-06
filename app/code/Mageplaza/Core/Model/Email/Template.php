<?php

namespace Mageplaza\Core\Model;

use Zend_Mail;
use Zend_Mail_Transport_Smtp;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

class Email
{
    protected $_mail;
    protected $scopeConfig;
    protected $storeManager;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    public function getMail()
    {
        if (is_null($this->_mail)) {
            $mySmtpHost = $this->scopeConfig->getValue('system/smtp/host');
            $mySmtpPort = $this->scopeConfig->getValue('system/smtp/port');

            $config = [
                'port' => $mySmtpPort,
                'auth' => 'login',
                'ssl' => 'tls',
                'username' => 'youremail@gmail.com',
                'password' => 'Abc',
            ];

            $transport = new Zend_Mail_Transport_Smtp($mySmtpHost, $config);
            Zend_Mail::setDefaultTransport($transport);

            $this->_mail = new Zend_Mail('utf-8');
        }
        return $this->_mail;
    }

    public function sendEmail($to, $subject, $body)
    {
        $this->getMail();

        $storeId = $this->storeManager->getStore()->getId();

        $this->_mail->setFrom('youremail@gmail.com', 'Your Name');
        $this->_mail->addTo($to);
        $this->_mail->setSubject($subject);
        $this->_mail->setBodyText($body);
        $this->_mail->setBodyHtml($body);

        try {
            $this->_mail->send();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

<?php
namespace Custom\Installationservice\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Escaper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

class Enquiry extends Action
{
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $storeManager;
    protected $escaper;
    protected $scopeConfig;
    protected $messageManager;
    protected $resultRedirect;
    protected $dataPersistor;
    protected $session;

    public function __construct(
        Context $context,
        SessionManagerInterface $session,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager,
        Escaper $escaper,
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager,
        DataPersistorInterface $dataPersistor,
        ResultFactory $resultFactory
    ) {
        parent::__construct($context);
        $this->session = $session;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
        $this->scopeConfig = $scopeConfig;
        $this->dataPersistor = $dataPersistor;
        $this->resultRedirect = $resultFactory;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();
        unset($postData['form_key']);
        
        $emailContent = "Name: " . $postData['name'] . "\n";
        $emailContent .= "Email: " . $postData['email'] . "\n";
        $emailContent .= "Title: " . $postData['title'] . "\n";
        $emailContent .= "Phone: " . $postData['phone'] . "\n";
        $emailContent .= "Message: " . $postData['message'];

        $contactEmail = $this->scopeConfig->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        try {
            // Send email to user
            $this->inlineTranslation->suspend();
            $templateOptions = ['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId()];
            $templateVars = [
                'name' => $postData['name'],
                'email' => $postData['email'],
                'title' => $postData['title'],
                'phone' => $postData['phone'],
                'message' => $postData['message'],
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('21') // Use the template ID for user email template
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom(['email' => 'developerayu09@gmail.com', 'name' => 'Ayushi'])
                ->addTo($postData['email'], $postData['name']) // Add recipient's email and name
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
            
            // Send email to admin
            $adminTransport = $this->transportBuilder
                ->setTemplateIdentifier('20') // Use the template ID for admin email template
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom(['email' => 'developerayu09@gmail.com', 'name' => 'Ayushi'])
                ->addTo($contactEmail, 'Admin') // Add admin's email and name
                ->getTransport();
            $adminTransport->sendMessage();

            $this->messageManager->addSuccessMessage(__('Form successfully submitted.'));

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $this->messageManager->addErrorMessage(__('There was an error processing your request. Please try again later.'));
            $this->session->setFormData($postData);
            $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->error($e);
        }

        return $this->resultRedirect->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
    }
}

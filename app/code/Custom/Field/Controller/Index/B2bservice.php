<?php
namespace Custom\Field\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Escaper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Message\ManagerInterface; // Add this line
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\App\Request\DataPersistorInterface; // Added this line

class B2bservice extends Action
{
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $storeManager;
    protected $escaper;
    protected $scopeConfig;
    protected $messageManager; // Add this line
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
        ManagerInterface $messageManager, // Add this line
        DataPersistorInterface $dataPersistor, // Add this dependency
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
        $this->messageManager = $messageManager; // Add this line
    }

    public function execute()
    {
        // Handle form submission here
        $postData = $this->getRequest()->getPostValue();
        
        // Remove the form key from the data array
        unset($postData['form_key']);
        
        // Send email
        $this->inlineTranslation->suspend();
        
        // Get the contact email from configuration
        $contactEmail = $this->scopeConfig->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        try {
            $subject = 'B2b Services';

            // Send email to user
            $userTransport = $this->transportBuilder
                ->setTemplateIdentifier(26) // Use your custom email template ID here
                ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId()])
                ->setTemplateVars([
                    'name' => $postData['development_name'],
                    'email' => $postData['email'],
                    'company' => $postData['company_name'],
                    'phone' => $postData['phone_number'],
                    'hiddenDialCode' => $postData['hiddenDialCode'],
                    'message' => $postData['message'],
                ])
                ->setFrom(['email' => 'developerayu09@gmail.com', 'name' => 'Mageleven']) // Use contact email as sender
                ->addTo($postData['email'], $postData['development_name']) // Add user's email and name
                ->getTransport();
            $userTransport->getMessage()->setSubject($subject);
            $userTransport->sendMessage();

            // Send email to admin
            $adminTransport = $this->transportBuilder
                ->setTemplateIdentifier(25) // Use your custom email template ID here
                ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId()])
                ->setTemplateVars([
                    'name' => $postData['development_name'],
                    'email' => $postData['email'],
                    'company' => $postData['company_name'],
                    'phone' => $postData['phone_number'],
                    'hiddenDialCode' => $postData['hiddenDialCode'],
                    'message' => $postData['message'],
                ])
                ->setFrom(['email' => 'developerayu09@gmail.com', 'name' => 'Mageleven']) // Use contact email as sender
                ->addTo($contactEmail, 'Admin') // Add admin email and name
                ->getTransport();
            $adminTransport->getMessage()->setSubject($subject);
            $adminTransport->sendMessage();

            $this->inlineTranslation->resume();
            $this->messageManager->addSuccessMessage(__('Form successfully submitted.'));

        } catch (\Exception $e) {
            // If sending email fails, log the error
            $errorMessage = $e->getMessage();
            $this->messageManager->addErrorMessage(__('There was an error processing your request. Please try again later.'));
            $this->session->setFormData($postData); // Persist form data for re-populating the form
            $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->error($e);
        }

        // Redirect after processing
        $resultRedirect = $this->resultRedirect->create(ResultFactory::TYPE_REDIRECT);
        // Redirect to the previous page
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}

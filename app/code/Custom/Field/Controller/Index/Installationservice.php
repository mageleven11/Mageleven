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


class Installationservice extends Action
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
        
        // Prepare email content
        $emailContent = "Name: " . $postData['development_name'] . "\n";
        $emailContent .= "Email: " . $postData['email'] . "\n";
        $emailContent .= "Title: " . $postData['title'] . "\n";
        $emailContent .= "Description: " . $postData['description'];

        // Send email
        $this->inlineTranslation->suspend();
          // Get the contact email from configuration
        $contactEmail = $this->scopeConfig->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        try {
            $subject = 'Installation Service';
            $transport = $this->transportBuilder
            ->setTemplateIdentifier(17) // Use your custom email template ID here
            ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId()])
            ->setTemplateVars([
                'name' => $postData['development_name'],
                'email' => $postData['email'],
                'title' => $postData['title'],
                'description' => $postData['description'],
                ])
            ->setFrom(['email' => 'developerayu09@gmail.com', 'name' => 'Ayushi']) // Use contact email as sender
            ->addTo($postData['email'], $postData['development_name']) // Add user's email and name
            ->addTo($contactEmail, 'Admin') // Add admin email and name
            ->getTransport();
            $transport->getMessage()->setSubject($subject);
            $transport->sendMessage();
            $this->inlineTranslation->resume();
            $this->messageManager->addSuccessMessage(__('Form successfully submitted.'));
                   // Your form processing logic here
            $resultRedirect = $this->resultRedirect->create(ResultFactory::TYPE_REDIRECT);
            // Redirect to the previous page
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            } catch (\Exception $e) {
             $errorMessage = $e->getMessage();
            $this->messageManager->addErrorMessage(__('There was an error processing your request. Please try again later.'));
            $this->session->setFormData($postData); // Persist form data for re-populating the form
            $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->error($e);
         // $errorMessage = $e->getMessage();
         //    $this->messageManager->addError(__($errorMessage));
        }
        // return $resultRedirect;
                //return $this->resultRedirectFactory->create()->setPath('customfield/index');
                return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());


    }
}

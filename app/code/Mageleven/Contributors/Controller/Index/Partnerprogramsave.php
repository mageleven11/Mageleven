<?php
namespace Mageleven\Contributors\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Escaper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Message\ManagerInterface; // Add this line


class Partnerprogramsave extends Action
{
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $storeManager;
    protected $escaper;
    protected $scopeConfig;
    protected $messageManager; // Add this line
    protected $resultRedirect;

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager,
        Escaper $escaper,
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager, // Add this line
        ResultFactory $resultFactory

    ) {
        parent::__construct($context);
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
        $this->scopeConfig = $scopeConfig;
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
        $emailContent = "Name: " . $postData['name'] . "\n";
        $emailContent .= "Email: " . $postData['email'];
        
        // Send email
        $this->inlineTranslation->suspend();
          // Get the contact email from configuration
        $contactEmail = $this->scopeConfig->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        try {
             $transport = $this->transportBuilder
            ->setTemplateIdentifier(12) // Use your custom email template ID here
            ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId()])
            ->setTemplateVars([
                'name' => $postData['name'],
                'email' => $postData['email']])
            ->setFrom(['email' => 'developerayu09@gmail.com', 'name' => 'Ayushi']) // Use contact email as sender
            ->addTo($postData['email'], $postData['name']) // Add user's email and name
            ->addTo($contactEmail, 'Admin') // Add admin email and name
            ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
             $this->messageManager->addSuccessMessage(__('Form successfully submitted.'));
               // Your form processing logic here
        $resultRedirect = $this->resultRedirect->create(ResultFactory::TYPE_REDIRECT);
        // Redirect to the previous page
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        } catch (\Exception $e) {
         $errorMessage = $e->getMessage();
            $this->messageManager->addError(__($errorMessage));
        }
        return $resultRedirect;

            
        // Redirect after processing
        // $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        // $resultRedirect->setUrl('/'); // Redirect to home page after form submission
        // return $resultRedirect;
    }
}

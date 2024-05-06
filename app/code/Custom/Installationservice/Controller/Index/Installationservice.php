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
use Magento\Framework\Message\ManagerInterface; // Add this line
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\App\Request\DataPersistorInterface; // Added this line
use Custom\Installationservice\Model\CustomreviewFactory;




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
    protected $customreviewFactory;



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
        ResultFactory $resultFactory,
        CustomreviewFactory $customreviewFactory


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
        $this->customreviewFactory = $customreviewFactory;


    }

    public function execute()
    {
        // Handle form submission here
        $postData = $this->getRequest()->getPostValue();
        // Remove the form key from the data array
        unset($postData['form_key']);
        
        try {
            $model = $this->customreviewFactory->create();
            $model->setData($postData)->save();
            $this->messageManager->addSuccessMessage(__('Form successfully submitted.'));
            $resultRedirect = $this->resultRedirect->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            } catch (\Exception $e) {
             $errorMessage = $e->getMessage();
            $this->messageManager->addErrorMessage(__('There was an error processing your request. Please try again later.'));
            
        }
            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());


    }
}

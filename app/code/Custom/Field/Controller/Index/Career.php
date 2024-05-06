<?php
namespace Custom\Field\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Career extends Action
{
    protected $_resultPageFactory;
    
    protected $_modelDataFactory;
    protected $uploaderFactory; // Declare $uploader property
    protected $filesystem; // Declare $filesystem property
    protected $_scopeConfig; // Declare $_scopeConfig property
    protected $_transportBuilder; // Declare $_transportBuilder property
    protected $inlineTranslation; // Declare $inlineTranslation property
    protected $resultRedirect;

 
    public function __construct(
        Context $context,       
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory, // Use factory to instantiate uploader
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Custom\Field\Model\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        ResultFactory $resultFactory,
    )
    {           
        $this->_resultPageFactory = $resultPageFactory;
        $this->uploaderFactory = $uploaderFactory; // Assign uploader factory instead of uploader
        $this->filesystem = $filesystem;
        $this->_scopeConfig = $scopeConfig;
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->resultRedirect = $resultFactory;
        parent::__construct($context);        
    }

    public function execute()
    {  
     try{
    $request = $this->getRequest()->getParams();   
    // echo "<pre>";
    // print_r($request);
    // die;
    // Check if the file was uploaded successfully
    if(isset($_FILES['myfile']) && $_FILES['myfile']['error'] === UPLOAD_ERR_OK) {
        // Retrieve file information
        $fileInfo = $_FILES['myfile'];
        
        // Specify the directory where you want to save the uploaded files
        $baseMediaPath = 'Mital/Careers';
        $mediaDirectory = $this->filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $targetDirectory = $mediaDirectory->getAbsolutePath($baseMediaPath);
        
        // Move the uploaded file to the target directory
        $targetFile = $targetDirectory . DIRECTORY_SEPARATOR . $fileInfo['name'];
        if(move_uploaded_file($fileInfo['tmp_name'], $targetFile)) {
            // File uploaded successfully
            $this->messageManager->addSuccess(__('File uploaded successfully.'));
            $fileName = $fileInfo['name']; // Define $fileName variable
        } else {
            // Failed to move the uploaded file
            $this->messageManager->addError(__('Failed to upload file. Please try again.'));
        }
    } else {
        // No file uploaded or an error occurred during upload
        $this->messageManager->addError(__('Please select a file to upload.'));
    }

    $templateVars = [
        'name' =>      $request['development_name'],       
        'email'     => $request['email'],
        'phone'  => $request['telephone'],
        'career' => $request['career'],
        'exp'  => $request['exp'],
        'countrycode' => $request['hiddenDialCode'],
        'message'  => $request['message']
       
    ];
    $fromEmail= 'mageleven9829@yopmail.com';
    $fromName = 'Mageleven';

    $from = ['email' => $fromEmail, 'name' => $fromName];

    $this->inlineTranslation->suspend();

    $to =  $this->_scopeConfig->getValue(
        'contact/email/recipient_email',
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
    );         
    $templateOptions = [
      'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
      'store' => 1
    ];        
    if(isset($fileName)){
    try {
        // Add attachment to email transport
        $transport = $this->_transportBuilder->setTemplateIdentifier('careers_email_template')
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->addAttachment(file_get_contents($targetFile), $fileName ,'application/pdf')
            ->setFrom($from)
            ->addTo($to)
            ->getTransport();
    } catch (\Exception $e) {
        // Log or display error message
        echo "Error adding attachment: " . $e->getMessage();
    }    
   } else {
        $transport = $this->_transportBuilder->setTemplateIdentifier('careers_email_template')
        ->setTemplateOptions($templateOptions)
        ->setTemplateVars($templateVars)                
        ->setFrom($from)
        ->addTo($to)
        ->getTransport();
    }
    
    $transport->sendMessage();
    $this->inlineTranslation->resume();

    $this->messageManager->addSuccess(__('Form successfully submitted'));

    // $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
    // $redirect->setUrl($this->_redirect->getRefererUrl());
    // return $redirect;
            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());


}catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }           
           
    }
    
}

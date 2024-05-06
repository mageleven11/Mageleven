<?php
namespace Mageleven\Extensionidea\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem\Directory\WriteInterface;
class Save extends Action
{
    protected $resultPageFactory;
    protected $allextensionideaFactory;
    protected $messageManager; 
    protected $filesystem;
    protected $fileUploader;
    protected $mediaDirectory;





    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Mageleven\Extensionidea\Model\AllextensionideaFactory $allextensionideaFactory,
        ManagerInterface $messageManager,
        Filesystem $filesystem,
        UploaderFactory $fileUploader
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->allextensionideaFactory = $allextensionideaFactory;
        $this->messageManager = $messageManager;
        $this->filesystem = $filesystem;
        $this->fileUploader = $fileUploader;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            
            // this folder will be created inside "pub/media" folder
            $yourFolderName = 'extensionidea/';
             
            // "upload_custom_file" is the HTML input file name
            $yourInputFileName = 'attachment';
            $data = (array)$this->getRequest()->getPost();
            
            if ($data) {
                $file = $this->getRequest()->getFiles($yourInputFileName);
                 $fileName = ($file && array_key_exists('name', $file)) ? $file['name'] : null;
                 
                 if ($file && $fileName) {
                 $target = $this->mediaDirectory->getAbsolutePath($yourFolderName); 
                 
                 /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
                 $uploader = $this->fileUploader->create(['fileId' => $yourInputFileName]);
                 
                 // set allowed file extensions
                 $uploader->setAllowedExtensions(['jpg', 'pdf', 'doc', 'png', 'zip']);
                 
                 // allow folder creation
                 $uploader->setAllowCreateFolders(true);
                 
                 // rename file name if already exists 
                 $uploader->setAllowRenameFiles(true); 
                 
                 // upload file in the specified folder
                 $result = $uploader->save($target);
                 
                 $data['attachment']=$result['file'];
                }

                $model = $this->allextensionideaFactory->create();
                // print_r($model->debug());
                // die("sfsfsf");
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;

    }
}

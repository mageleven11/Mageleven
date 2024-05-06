<?php

namespace Mageleven\Career\Controller\Adminhtml\Allcareer;

use Magento\Backend\App\Action;
use Mageleven\Career\Model\Allcareer;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Validation\ValidationException;
use Magento\MediaStorage\Model\File\UploaderFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Mageleven\Career\Model\AllcareerFactory
     */
    private $allcareerFactory;

    /**
     * @var \Mageleven\Career\Api\AllcareerRepositoryInterface
     */
    private $allcareerRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Mageleven\Career\Model\AllcareerFactory $allcareerFactory
     * @param \Mageleven\Career\Api\AllcareerRepositoryInterface $allcareerRepository
     */

     /**
       *
       * @var UploaderFactory
       */
      protected $uploaderFactory;


      /** 
       * @var Filesystem\Directory\WriteInterface 
       */
      protected $mediaDirectory;


    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Mageleven\Career\Model\AllcareerFactory $allcareerFactory = null,
        \Mageleven\Career\Api\AllcareerRepositoryInterface $allcareerRepository = null,

        UploaderFactory $uploaderFactory,
        Filesystem $filesystem
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->allcareerFactory = $allcareerFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Mageleven\Career\Model\AllcareerFactory::class);
        $this->allcareerRepository = $allcareerRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Mageleven\Career\Api\AllcareerRepositoryInterface::class);
            $this->uploaderFactory = $uploaderFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Mageleven_Career::save');
	}

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
         //echo "<pre>"; print_r($data); die;
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Allcareer::STATUS_ENABLED;
            }
            if (empty($data['career_id'])) {
                $data['career_id'] = null;
            }
            
            if(isset($data['image'])){

                $imageId = 'image';
                if (isset($data['image']) && count($data['image'])) {
                    $imageId = $data['image'][0];
                    if (isset($imageId['tmp_name'])){
                        if (!file_exists($imageId['tmp_name'])) {
                            $imageId['tmp_name'] = $imageId['path'] . '/' . $imageId['file'];
                        }
                    }
                }
                if (isset($imageId['tmp_name'])){
                    $fileUploader = $this->uploaderFactory->create(['fileId' => $imageId]);
                    $fileUploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
                    $fileUploader->setAllowRenameFiles(true);
                    $fileUploader->setAllowCreateFolders(true);
                    $fileUploader->validateFile();
                    //upload image
                    $info = $fileUploader->save($this->mediaDirectory->getAbsolutePath('imageUploader/images'));
                    /** @var \Itheavens\ImageUploader\Model\Image */

                    $data['image'] =  $info['file'];
                } else {
                    $data['image'] = $data['image'][0]['name'];
                }
            } else {
                $data['image'] = '';
            }

            /** @var \Mageleven\Career\Model\Allcareer $model */
            $model = $this->allcareerFactory->create();

            $id = $this->getRequest()->getParam('career_id');
            if ($id) {
                try {
                    $model = $this->allcareerRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This career no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'career_allcareer_prepare_save',
                ['allcareer' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->allcareerRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the career.'));
                $this->dataPersistor->clear('career_allcareer');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['career_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the career.'));
            }

            $this->dataPersistor->set('career_allcareer', $data);
            return $resultRedirect->setPath('*/*/edit', ['career_id' => $this->getRequest()->getParam('career_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

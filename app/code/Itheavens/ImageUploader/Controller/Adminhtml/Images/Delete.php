<?php
namespace Itheavens\ImageUploader\Controller\Adminhtml\Images;

use Itheavens\ImageUploader\Model\Image as Image;


class Delete extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Images';

    protected $resultPageFactory;
    protected $indexFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Itheavens\ImageUploader\Model\ImageFactory $indexFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->indexFactory = $indexFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('image_id');

        $image = $this->indexFactory->create()->load($id);

        if(!$image)
        {
            $this->messageManager->addError(__('Unable to process. please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', array('_current' => true));
        }

        try{
            $image->delete();
            $this->messageManager->addSuccess(__('Your Image has been deleted !'));
        }
        catch(\Exception $e)
        {
            $this->messageManager->addError(__('Error while trying to delete Image'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}
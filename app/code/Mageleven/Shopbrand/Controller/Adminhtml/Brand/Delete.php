<?php
namespace Mageleven\Shopbrand\Controller\Adminhtml\Brand;

class Delete extends \Mageleven\Shopbrand\Controller\Adminhtml\Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('shopbrand_id');
        try {
            $item = $this->_shopbrandFactory->create()->setId($id);
            $item->delete();
            $this->messageManager->addSuccess(
                __('Delete successfully !')
            );
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        $resultRedirect = $this->_resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}

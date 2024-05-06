<?php
namespace Mageleven\Shopbrand\Controller\Adminhtml\Brand;
use Magento\Framework\Controller\ResultFactory;
class MassDelete extends \Mageleven\Shopbrand\Controller\Adminhtml\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */

    protected $_resultRedirectFactory;
    public function execute()
    {
          /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        
        $shopbrandIds = $this->getRequest()->getParam('shopbrand');
        if (!is_array($shopbrandIds) || empty($shopbrandIds)) {
            $this->messageManager->addError(__('Please select shopbrand(s).'));
        } else {
            $collection = $this->_shopbrandCollectionFactory->create()
                ->addFieldToFilter('shopbrand_id', ['in' => $shopbrandIds]);
            try {
                foreach ($collection as $item) {
                    $item->delete();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been deleted.', count($shopbrandIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        
        return $resultRedirect->setPath('*/*/');
        
    }
}

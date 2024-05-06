<?php
namespace Custom\Installationservice\Controller\Adminhtml\customreview;

use Magento\Backend\App\Action;

class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * Update blog post(s) status action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {

        $itemIds = $this->getRequest()->getParam('customreview');
        if (!is_array($itemIds) || empty($itemIds)) {
            $this->messageManager->addError(__('Please select item(s).'));
        } else {
            try {

                $status = (int) $this->getRequest()->getParam('status');
                foreach ($itemIds as $postId) {
                    $post = $this->_objectManager->get('Custom\Installationservice\Model\Customreview')->load($postId);
                    $post->setStatus($status)->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been updated.', count($itemIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $this->resultRedirectFactory->create()->setPath('installationservice/*/index');
    }

}
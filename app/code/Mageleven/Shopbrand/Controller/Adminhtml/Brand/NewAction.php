<?php
namespace Mageleven\Shopbrand\Controller\Adminhtml\Brand;

class NewAction extends \Mageleven\Shopbrand\Controller\Adminhtml\Action
{
    public function execute()
    {
        $resultForward = $this->_resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}

<?php
namespace Mageleven\Shopbrand\Controller\Index;

use Magento\Framework\Controller\ResultFactory; 

class Product extends \Mageleven\Shopbrand\Controller\Index
{
    /**
     * Default customer account page.
     */
    public function execute()
    {
    	if ($this->getRequest()->isAjax()) {
	        $this->_view->loadLayout();
	        // $this->_view->renderLayout();
	        $info = $this->getRequest()->getParam('info');
	        $type = $this->getRequest()->getParam('type');
	        $tmp = $info['timer'] ? 'product/gridtimer.phtml':'product/grid.phtml';
	        $products = $this->_view->getLayout()->createBlock('Mageleven\Shopbrand\Block\Product\GridProduct')
					            ->setCfg($info)
					           	->setActivated($type)
					           	->setTemplate($tmp)
					           	->toHtml();
	        $this->getResponse()->setBody( $products );
	    }else {
	        $resultRedirect = $this->_resultPageFactory->create(ResultFactory::TYPE_REDIRECT);
	        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
	        return $resultRedirect;
	    }
    }
}

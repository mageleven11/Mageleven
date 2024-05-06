<?php

namespace Mageleven\Discountrule\Block;

Class ViewDiscountrule extends \Magento\Framework\View\Element\Template
{
	protected $allDiscountruleFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Mageleven\Discountrule\Model\AlldiscountruleFactory $allDiscountruleFactory
	){
		parent::__construct($context);
		$this->allDiscountruleFactory = $allDiscountruleFactory;
	}
	
	public function getDiscountrule()
	{
		$id = $this->getRequest()->getParam('id');
		$discountrule = $this->allDiscountruleFactory->create()->load($id);
		
		return $discountrule;
	}
	
	protected function _prepareLayout(){
		
		parent::_prepareLayout();
		
		$discountrule = $this->getDiscountrule();
		$this->pageConfig->getTitle()->set($discountrule->getTitle());
		
        return $this;
	}
}
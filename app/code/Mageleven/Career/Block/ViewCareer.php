<?php

namespace Mageleven\Career\Block;

Class ViewCareer extends \Magento\Framework\View\Element\Template
{
	protected $allCareerFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Mageleven\Career\Model\AllcareerFactory $allCareerFactory
	){
		parent::__construct($context);
		$this->allCareerFactory = $allCareerFactory;
	}
	
	public function getCareer()
	{
		$id = $this->getRequest()->getParam('id');
		$career = $this->allCareerFactory->create()->load($id);
		
		return $career;
	}
	
	protected function _prepareLayout(){
		
		parent::_prepareLayout();
		
		$career = $this->getCareer();
		$this->pageConfig->getTitle()->set($career->getTitle());
		
        return $this;
	}
}
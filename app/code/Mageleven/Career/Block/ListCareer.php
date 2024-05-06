<?php

namespace Mageleven\Career\Block;

Class ListCareer extends \Magento\Framework\View\Element\Template
{
	protected $allCareerFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Mageleven\Career\Model\AllcareerFactory $allCareerFactory
	){
		parent::__construct($context);
		$this->allCareerFactory = $allCareerFactory;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
	
	public function getListCareer()
	{
		$page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
		$limit = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 4;
		
		$collection = $this->allCareerFactory->create()->getCollection();
		$collection->addFieldToFilter('status',1);
		$collection->setPageSize($limit);
		$collection->setCurPage($page);
	
		return $collection;
	}
	
	protected function _prepareLayout(){
		parent::_prepareLayout();
		//$this->pageConfig->getTitle()->set(__('Latest Career'));
		
		if ($this->getListCareer()){
			$pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'mageleven.career.pager')
									->setAvailableLimit(array(4=>4,8=>8,12=>12,16=>16))
									->setShowPerPage(true)
									->setCollection($this->getListCareer());

			$this->setChild('pager', $pager);

			$this->getListCareer()->load();
		}
        return $this;
	}
	
	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}
}
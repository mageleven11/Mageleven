<?php

namespace Mageleven\Discountrule\Block;

Class ListDiscountrule extends \Magento\Framework\View\Element\Template
{
	protected $allDiscountruleFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Mageleven\Discountrule\Model\AlldiscountruleFactory $allDiscountruleFactory
	){
		parent::__construct($context);
		$this->allDiscountruleFactory = $allDiscountruleFactory;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
	
	public function getListDiscountrule()
	{
		$page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
		$limit = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 2;
		
		$collection = $this->allDiscountruleFactory->create()->getCollection();
		$collection->addFieldToFilter('status',1);
		$collection->setPageSize($limit);
		$collection->setCurPage($page);
	
		return $collection;
	}
	
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$this->pageConfig->getTitle()->set(__('Latest Discountrule'));
		
		if ($this->getListDiscountrule()){
			$pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'mageleven.discountrule.pager')
									->setAvailableLimit(array(2=>2,10=>10,15=>15,20=>20))
									->setShowPerPage(true)
									->setCollection($this->getListDiscountrule());

			$this->setChild('pager', $pager);

			$this->getListDiscountrule()->load();
		}
        return $this;
	}
	
	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}
}
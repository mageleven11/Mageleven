<?php

namespace Mageleven\Discountrule\Block;

Class LinkDiscountrule extends \Magento\Framework\View\Element\Template
{
	protected $dataHelper;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Mageleven\Discountrule\Helper\Data $dataHelper
	){
		parent::__construct($context);
		$this->dataHelper = $dataHelper;
	}
	
	public function getDiscountruleLink()
	{
		$discountruleLink = $this->dataHelper->getStorefrontConfig('discountrule_link');
		
		return $discountruleLink;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}
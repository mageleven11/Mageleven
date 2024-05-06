<?php

namespace Mageleven\Career\Block;

Class LinkCareer extends \Magento\Framework\View\Element\Template
{
	protected $dataHelper;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Mageleven\Career\Helper\Data $dataHelper
	){
		parent::__construct($context);
		$this->dataHelper = $dataHelper;
	}
	
	public function getCareerLink()
	{
		$careerLink = $this->dataHelper->getStorefrontConfig('career_link');
		
		return $careerLink;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}
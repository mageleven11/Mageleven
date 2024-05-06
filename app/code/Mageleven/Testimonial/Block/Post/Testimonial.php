<?php

namespace Mageleven\Testimonial\Block\Post;

class Testimonial extends \Magento\Framework\View\Element\Template 
{
	/**
	 * @var \Magento\Customer\Model\Session
	 */
	protected $customerSession;

	/**
	 * @var \Mageleven\Testimonial\Model\TestimonialFactory
	 */
	protected $testimonialFactory;

	/**
	 * @var \Mageleven\Testimonial\Helper\Data
	 */
	public $helper;

	/**
	 * @param \Magento\Framework\View\Element\Template\Context $context 
	 * @param \Mageleven\Testimonial\Model\TestimonialFactory $testimonialFactory
	 * @param \Magento\Customer\Model\Session $customerSession
	 * @param array $data
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Customer\Model\Session $customerSession,
		\Mageleven\Testimonial\Model\TestimonialFactory $testimonialFactory,
		\Mageleven\Testimonial\Helper\Data $helper,

		array $data = []
	) {
		parent::__construct($context, $data);

		$this->customerSession 	  = $customerSession;		
		$this->testimonialFactory = $testimonialFactory;
		$this->helper 			  = $helper;
		$this->pageConfig->getTitle()->set(__('Submit Your Testimonial'));
	}

	/**
	 * Add elements in layout
	 *
	 * @return
	 */
	protected function _prepareLayout()
	{
		return parent::_prepareLayout();
	}

	public function getCustomerSession()
	{
		return $this->customerSession;
	}
	
	/**
	 * @return
	 */
	public function getTestimonial() {
		$store = $this->_storeManager->getStore()->getId();
		$collection = $this->_testimonialFactory->create()->getCollection()
			->addFieldToFilter('status', 1)
			->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)));

		$collection->setOrderByTestimonial();

		return $collection;
	}

	public function getStoreId()
	{
		return $this->_storeManager->getStore()->getId();
	}

	public function getConfig($config)
	{
		return $this->helper->getConfigModule('general/'.$config);
	}
	
	/**
	 * @return
	 */
	protected function _toHtml() 
	{
		// if(!$this->helper->getConfigModule('general/enabled')) return;
		return parent::_toHtml();
	}
	
	public function getFormAction()
    {
        return $this->getUrl('testimonial/index/post', ['_secure' => true]);
    }

}
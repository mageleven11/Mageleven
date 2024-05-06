<?php

/**
 * @Author: nguyen
 * @Date:   2021-06-17 11:58:22
 * @Last Modified by:   nguyen
 * @Last Modified time: 2021-06-17 12:01:51
 */

namespace Mageleven\Testimonial\Block\Post;

use Magento\Framework\UrlInterface;

class TestimonialList extends \Magento\Framework\View\Element\Template
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
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Mageleven\Testimonial\Model\TestimonialFactory $testimonialFactory
     * @param \Mageleven\Testimonial\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Mageleven\Testimonial\Model\TestimonialFactory $testimonialFactory,
        \Mageleven\Testimonial\Helper\Data $helper,
        array $data = []
     ) 
    {
		$this->customerSession    = $customerSession;
        $this->testimonialFactory = $testimonialFactory;
        $this->helper             = $helper;
    
        parent::__construct($context, $data);
        //get collection of data 
        $collection = $this->testimonialFactory->create()->getCollection();
		$collection->addFieldToFilter('status',1);
		$collection->getSelect()->order(array('order asc', 'testimonial_id desc'));
        $this->setCollection($collection);
        $this->pageConfig->getTitle()->set(__('Testimonials'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCollection()) {
            // create pager block for collection 
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'mageleven.testimonial.record.pager'
            );
			$pager->setAvailableLimit(array($this->getConfig('per_page')=>$this->getConfig('per_page')));
			$pager->setCollection(
                $this->getCollection() // assign collection to pager
            );
            $this->setChild('pager', $pager);// set pager block in layout
        }
        return $this;
    }
  
    /**
     * @return string
     */
    // method for get pager html
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    } 

    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK);
    }
	
	public function getMediaUrl()
    {
		return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).'/testimonial/image';
    }
	
	public function getMediabaseUrl()
    {
		$media_folder = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
		return $media_folder;
    }
	
	public function checklogin()
	{
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cutomerLogin = $objectManager->create('Magento\Customer\Model\Session');
		return $cutomerLogin->isLoggedIn();
	}
	
	public function getDefaultImage()
    {
        return $this->getViewFileUrl('Mageleven_testimonial::images/default.jpg');
    }
	
    public function getConfig($config)
    {
        return $this->helper->getConfigModule('general/'.$config);
    }

}

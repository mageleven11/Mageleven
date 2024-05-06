<?php

namespace Itheavens\Fanpage\Block\Index;

class Index extends \Magento\Framework\View\Element\Template 
{
	protected $helper;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
        \Itheavens\Fanpage\Helper\Data $helper
    ) {
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function getPagesGroupHome() {
        return $this->helper->getPages();
    }

    public function getMediaPathUrlHome($imageUrl) {
        return $this->helper->getMediaUrl($imageUrl);
    }

    // public function getSpecialDealsHome() {
	   //  return $this->helper->getSpecialDeals();
    // }

    public function getFormattedPriceHome($price) {
	    return $this->helper->getFormattedPrice($price);
    }

    public function getFeaturedProductsHome() {
        return $this->helper->getFeaturedProducts();
    }

    public function getTotalReviewHome($productId) {
        return $this->helper->getTotalReview($productId);
    }

    public function getNewProductHome() {
        return $this->helper->getNewProduct();
    }

    public function getImageListHome() {
        return $this->helper->getImageList();
    }
}

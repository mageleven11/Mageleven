<?php
namespace Mageleven\SeoTags\Block;
use Magento\Catalog\Helper\Data;
use Magento\Review\Block\Product\View as ReviewProductBlock;

class CustomTags extends \Magento\Framework\View\Element\Template
{
	protected $request;
	protected $helper;
	protected $reviewProductBlock;
	protected $_review;
	protected $_ratingFactory;

    public function __construct(
    	    \Magento\Backend\Block\Template\Context $context,
			\Magento\Theme\Block\Html\Header\Logo $logo,
			Data $helper,
			\Magento\Framework\App\Request\Http $request,
			ReviewProductBlock $reviewProductBlock,
			\Magento\Review\Model\Review $review,
			\Magento\Review\Model\Rating $ratingFactory,
			array $data = []) {
    			$this->logo = $logo;
    			$this->request = $request;
				$this->helper = $helper;
				$this->reviewProductBlock = $reviewProductBlock;
				$this->_review = $review;
    			$this->_ratingFactory = $ratingFactory;
				parent::__construct($context, $data);
		}
	protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function isHomePage(){
	     return $this->logo->isHomePage();

    }
    public function getCurrectAction(){
    	if($this->request->getFullActionName() == 'catalog_product_view'){
    		return true;
    	}
    }
    public function getProduct(){
	    
	        return $this->helper->getProduct();
	    
	}
	

	 public function getTotalReviews()
    {
        // Call getReviewsCollection() from the ReviewProductBlock instance
        $reviewsCollection = $this->reviewProductBlock->getReviewsCollection();

        // Now you can process $reviewsCollection as needed
        // For example, you can count the total reviews:
        $totalReviews = $reviewsCollection->getSize();

        return $totalReviews;
    }
    public function getReviewRatting(){
 		$product = $this->helper->getProduct(); 
   		$reviewFactory = $this->_review;
		//$storeId = '1';
		//$reviewFactory->getEntitySummary($product, $storeId);
		$reviewFactory->getEntitySummary($product);
		$ratingSummary = $product->getRatingSummary()->getRatingSummary();
		$rat = (int)$ratingSummary;
		$outOf_five = ($rat * 5) / 100;
		return $outOf_five;
	}
	 /**
     * Get logo image URL
     *
     * @return string
     */
    public function getLogoSrc()
    {    
        return $this->logo->getLogoSrc();
    }

}
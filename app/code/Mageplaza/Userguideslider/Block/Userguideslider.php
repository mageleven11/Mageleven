<?php
namespace Mageplaza\Userguideslider\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Review\Model\ReviewFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Pricing\Helper\Data;

class Userguideslider extends \Magento\Framework\View\Element\Template
{    
    protected $productCollectionFactory;
    protected $imageHelper;
    protected $productRepository;
    protected $_reviewFactory;
    protected $_storeManager;
    protected $_scopeConfig;
    protected $priceHelper;
        
    public function __construct(
        Data $priceHelper,
        \Magento\Backend\Block\Template\Context $context,        
        ProductCollectionFactory $productCollectionFactory,
        ImageHelper $imageHelper,
        ProductRepositoryInterface $productRepository,
        ReviewFactory $reviewFactory,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {    
        $this->productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $imageHelper;
        $this->productRepository = $productRepository;
        $this->_reviewFactory = $reviewFactory;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->priceHelper = $priceHelper;
        parent::__construct($context, $data);
    }
    
    public function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(['name', 'image', 'price']);
        $collection->setPageSize(10); // fetching only 10 products
        return $collection;
    }
    
    public function getProductRating($productId)
    {
        try {
            $product = $this->productRepository->getById($productId);
            $ratingSummary = $this->_reviewFactory->create()->getEntitySummary($product, $this->_storeManager->getStore()->getId());
            
            if (!$ratingSummary->getReviewsCount()) {
                return ['averageRating' => 0, 'reviewCount' => 0];
            }
            
            $ratingSummaryData = $ratingSummary->getData();
            $averageRating = $ratingSummaryData['rating_summary'] / 20; // Convert the rating to a 5-star scale

            return [
                'averageRating' => number_format($averageRating, 1),
                'reviewCount' => $ratingSummaryData['reviews_count']
            ];
        } catch (\Exception $e) {
            // Handle exception (e.g., log error)
            return ['averageRating' => 0, 'reviewCount' => 0];
        }
    }
    public function getFormattedPrice($price)
{
    return $this->priceHelper->currency($price, true, false);
}
}
?>

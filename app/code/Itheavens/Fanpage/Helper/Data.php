<?php

namespace Itheavens\Fanpage\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
	protected $storeManager;

	protected $collectionFactory;

    protected $priceHelper;

    protected $imageHelper;

    protected $reviewFactory;

    protected $localeDate;

    protected $imageFactory;

    protected $request;

    protected $productloader;

    protected $resource;

    protected $registry;

    protected $discountrule;

    protected $pageFactory;

    protected $pageRepositoryInterface;

    protected $searchCriteriaBuilder;

    protected $customerSession;

	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepositoryInterface,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
		\Magento\Framework\Pricing\Helper\Data $priceHelper,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Itheavens\ImageUploader\Model\ResourceModel\Image\CollectionFactory $imageFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Catalog\Model\ProductFactory $productloader,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Registry $registry,
        \Mageleven\Discountrule\Model\Alldiscountrule $discountrule,
        \Magento\Cms\Model\Page $pageFactory,
        \Magento\Customer\Model\Session $customerSession
	)
	{
		$this->pageRepositoryInterface = $pageRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
		$this->storeManager = $storeManager;
		$this->collectionFactory = $collectionFactory;
		$this->priceHelper = $priceHelper;
        $this->imageHelper = $imageHelper;
        $this->reviewFactory = $reviewFactory;
        $this->localeDate = $localeDate;
        $this->imageFactory = $imageFactory;
        $this->request = $request;
        $this->productloader = $productloader;
        $this->resource = $resource;
        $this->registry = $registry;
        $this->discountrule = $discountrule;
        $this->pageFactory = $pageFactory;
        $this->customerSession = $customerSession;
		parent::__construct($context);
	}

    public function getPages() 
    {
        $searchCriteria = $this->searchCriteriaBuilder
        ->addFilter('is_active', '1')
        ->addFilter('mageleven_solutions_home_group', '1')
        ->create();
        $pages = $this->pageRepositoryInterface->getList($searchCriteria)->getItems();
        return $pages;
    }

	public function getMediaUrl($imagePath)
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $imagePath;
    }

    // public function getSpecialDeals() 
    // {
    // 	$todayStartOfDayDate = $this->localeDate->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
    //     $todayEndOfDayDate = $this->localeDate->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');
	   //  $productCollection = $this->collectionFactory->create();
	   //  $productCollection->addAttributeToSelect('*');
	   //  $productCollection->addAttributeToFilter('special_price', ['neq' => '']);
    //     $productCollection->addAttributeToFilter('special_from_date', ['neq' => '']);
    //     $productCollection->addAttributeToFilter('special_to_date', ['neq' => '']);
    //     $productCollection->addAttributeToFilter(
    //         'special_from_date',
    //         [
    //             'or' => [
    //                 0 => ['date' => true, 'to' => $todayEndOfDayDate],
    //                 1 => ['is' => new \Zend_Db_Expr('null')],
    //             ]
    //         ],
    //         'left'
    //     )->addAttributeToFilter(
    //         'special_to_date',
    //         [
    //             'or' => [
    //                 0 => ['date' => true, 'from' => $todayStartOfDayDate],
    //                 1 => ['is' => new \Zend_Db_Expr('null')],
    //             ]
    //         ],
    //         'left'
    //     )->addAttributeToFilter(
    //         [
    //             ['attribute' => 'special_from_date', 'is' => new \Zend_Db_Expr('not null')],
    //             ['attribute' => 'special_to_date', 'is' => new \Zend_Db_Expr('not null')],
    //         ]
    //     );
    //     $productCollection->addAttributeToFilter('is_saleable', 1, 'left');
    //     $productCollection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
    //     $productCollection->getSelect()->limit(4);
	   //  //$productCollection->load();
	   //  return $productCollection;
    // }

    public function getFormattedPrice($price)
    {
    	return $this->priceHelper->currency($price, true, false);
    }

    public function getImageUrl($product)
    {
        return $this->imageHelper->init($product, 'product_page_image_small')
                ->setImageFile($product->getSmallImage()) 
                ->resize(380)
                ->getUrl();
    }

    public function getFeaturedProducts()
    {
        $productCollection = $this->collectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addAttributeToFilter('is_saleable', 1, 'left');
        $productCollection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $productCollection->addAttributeToFilter('is_featured',1);
        $productCollection->getSelect()->limit(12);
        //$productCollection->load();
        return $productCollection;
    }

    public function getTotalReview($productId)
    {
        $collection = $this->reviewFactory->create()
        ->addStoreFilter($this->storeManager->getStore()->getId())
        ->addStatusFilter(\Magento\Review\Model\Review::STATUS_APPROVED)
        ->addEntityFilter('product',$productId);
        return $collection->getSize();
    }

    public function getNewProduct() 
    {
        $todayStartOfDayDate = $this->localeDate->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $todayEndOfDayDate = $this->localeDate->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $productCollection = $this->collectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addStoreFilter();
        $productCollection->addAttributeToFilter(
            'news_from_date',
            [
                'or' => [
                    0 => ['date' => true, 'to' => $todayEndOfDayDate],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        )->addAttributeToFilter(
            'news_to_date',
            [
                'or' => [
                    0 => ['date' => true, 'from' => $todayStartOfDayDate],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        )->addAttributeToFilter(
            [
                ['attribute' => 'news_from_date', 'is' => new \Zend_Db_Expr('not null')],
                ['attribute' => 'news_to_date', 'is' => new \Zend_Db_Expr('not null')],
            ]
        );
        $productCollection->addAttributeToFilter('is_saleable', 1, 'left');
        $productCollection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $productCollection->getSelect()->limit(12);
        //$productCollection->load();
        return $productCollection;
    }

    public function getImageList()
    {
        return $collection = $this->imageFactory->create();
    }

    public function getPagePath()
    {
        return $this->request->getFullActionName();
    }

    public function getLoadProductPrice($id)
    {
        return $this->getFormattedPrice($this->productloader->create()->load($id)->getFinalPrice());
    }

    public function getProductRatingAverage($productId)
    {
        $connection = $this->resource->getConnection();
        $select = $connection->select()
        ->from(
            ['review_table' => 'review']
        )
        ->join(
            ['rating_table' => 'rating_option_vote'],
            'review_table.review_id = rating_table.review_id AND review_table.status_id = 1 AND review_table.entity_pk_value = '.$productId
        );
        $data = $connection->fetchAll($select);
        if(count($data) > 0) {
            $array=[];
            $count = count($data);
            foreach ($data as $key => $value) {
                $array[] = $value['value'];
            }
            return number_format((array_sum($array)/$count),1);
        } else {
            return '';
        }
    }

    public function getCurrentCategory()
    {       
        return $this->registry->registry('current_category');
    }

    public function getCurrentProduct()
    {       
        return $this->registry->registry('current_product');
    }

    public function getExtensionList(){
        $productCollection = $this->collectionFactory->create()->addAttributeToSelect('*');
        return $productCollection;
    }

   public function getDiscountByRule($price){
    $discount_percent = 0;
    $collection = $this->discountrule->getCollection()
    ->addFieldToFilter('price_from', array('lteq' => $price))
    ->addFieldToFilter('price_to', array('gteq' => $price))
    ->getData();
    if(!empty($collection) && isset($collection[0]['discount'])){
        $discount_percent = $collection[0]['discount'];
    }
    return $discount_percent;
}

    public function getImageResizeCategory($product,$height,$width)
    {
        return $this->imageHelper->init($product, 'product_page_image_small')
                ->setImageFile($product->getSmallImage()) 
                ->resize($height,$width)
                ->getUrl();
    }

    public function getLoadProduct($product)
    {
        return $this->productloader->create()->load($product);
    }

    public function getPageId()
    {
        return $this->pageFactory->getIdentifier();
    }

    public function customerSessionData()
    {
        return $this->customerSession;
    }

}
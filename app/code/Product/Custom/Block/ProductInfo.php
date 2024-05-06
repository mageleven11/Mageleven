<?php

namespace Product\Custom\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Registry;

class ProductInfo extends Template
{
    protected $productFactory;
    protected $registry;
    protected $currentProduct;

    public function __construct(
        Template\Context $context,
        ProductFactory $productFactory,
        Registry $registry,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getCurrentProduct()
    {
        return $this->currentProduct ?: $this->registry->registry('current_product');
    }

    public function setProduct($product)
    {
        $this->currentProduct = $product;
    }
}

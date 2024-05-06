<?php

namespace Product\Custom\Plugin\Catalog\Block\Product;

use Product\Custom\Block\ProductInfo;
use Magento\Catalog\Block\Product\View as ProductView;

class View
{
    protected $productInfoBlock;

    public function __construct(
        ProductInfo $productInfoBlock
    ) {
        $this->productInfoBlock = $productInfoBlock;
    }

    public function afterGetProduct(ProductView $subject, $result)
    {
        $currentProduct = $subject->getProduct();
        $this->productInfoBlock->setProduct($currentProduct);

        return $result;
    }
}

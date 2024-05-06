<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\AutoRelatedProduct\Plugin\Frontend\Magento\Catalog\Block\Product\ProductList;

use Mageleven\AutoRelatedProduct\Api\RelatedItemsProcessorInterface;

class Related
{
    /**
     * @param RelatedItemsProcessorInterface $relatedItemsProcessor
     */
    private $relatedItemsProcessor;

    /**
     * @param RelatedItemsProcessorInterface $relatedItemsProcessor
     */
    public function __construct(
        RelatedItemsProcessorInterface $relatedItemsProcessor
    ) {
        $this->relatedItemsProcessor = $relatedItemsProcessor;
    }

    /**
     * @param $subject
     * @param $result
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetItems($subject, $result)
    {
        return $this->relatedItemsProcessor->execute($subject, $result, 'product_into_related');
    }
}

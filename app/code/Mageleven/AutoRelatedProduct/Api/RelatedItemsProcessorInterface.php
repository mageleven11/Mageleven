<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\AutoRelatedProduct\Api;

use Magento\Framework\View\Element\AbstractBlock;

interface RelatedItemsProcessorInterface
{
    /**
     * @param AbstractBlock $subject
     * @param $result
     * @param $blockPosition
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(AbstractBlock $subject, $result, $blockPosition);
}

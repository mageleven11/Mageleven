<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Mageleven\AutoRelatedProduct\Api\Data;

/**
 * Interface RuleSearchResultsInterface
 */
interface RuleSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Rule list.
     * @return \Mageleven\AutoRelatedProduct\Api\Data\RuleInterface[]
     */
    public function getItems();

    /**
     * Set id list.
     * @param \Mageleven\AutoRelatedProduct\Api\Data\RuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

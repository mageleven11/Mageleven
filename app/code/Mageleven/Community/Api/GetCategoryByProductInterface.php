<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\Community\Api;

/**
 * Return category by product
 *
 * @api
 * @since 2.1.10
 */
interface GetCategoryByProductInterface
{
    /**
     * @param mixed $product
     * @param mixed $storeId
     * @returnmixed
     */
    public function execute($product, $storeId = null);
}

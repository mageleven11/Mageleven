<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\AutoRelatedProduct\Api;

interface ConfigInterface
{
    /**
     * Retrieve store config value
     * @param string $path
     * @param null $storeId
     * @return mixed
     */
    public function getConfig($path, $storeId = null);

    /**
     * Retrieve true if module is enabled
     *
     * @return bool
     */
    public function isEnabled($storeId = null);
}

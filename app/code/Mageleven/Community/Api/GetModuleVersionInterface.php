<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\Community\Api;

/**
 * Return module version by module name
 *
 * @api
 * @since 2.1.0
 */
interface GetModuleVersionInterface
{
    /**
     * Get module version
     *
     * @api
     * @param string $moduleName
     * @return string
     */
    public function execute(string $moduleName) : string;
}

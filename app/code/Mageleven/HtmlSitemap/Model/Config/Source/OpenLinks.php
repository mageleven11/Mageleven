<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\HtmlSitemap\Model\Config\Source;

class OpenLinks implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => '1',
                'label' => __('In the same tab')
            ],
            [
                'value' => '2',
                'label' => __('In a new tab')
            ]
        ];
    }
}

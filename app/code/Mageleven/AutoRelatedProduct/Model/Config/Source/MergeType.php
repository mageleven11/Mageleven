<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Mageleven\AutoRelatedProduct\Model\Config\Source;

/**
 * Class MergeType
 */
class MergeType implements \Magento\Framework\Data\OptionSourceInterface
{
    const MERGE   = 'Merge';
    const INSTEAD = 'Instead';

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function toOptionArray(): array
    {
        $options = [];
        $options = array_merge_recursive($options, [
            ['label' => __('Add to Current(Native) Related Products'), 'value' => self::MERGE],
            ['label' => __('Add Instead Current Related Products'), 'value' => self::INSTEAD]
        ]);

        return $options;
    }
}

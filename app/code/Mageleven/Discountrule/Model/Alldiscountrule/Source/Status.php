<?php

namespace Mageleven\Discountrule\Model\Alldiscountrule\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $allDiscountrule;

    public function __construct(\Mageleven\Discountrule\Model\Alldiscountrule $allDiscountrule)
    {
        $this->allDiscountrule = $allDiscountrule;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->allDiscountrule->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}

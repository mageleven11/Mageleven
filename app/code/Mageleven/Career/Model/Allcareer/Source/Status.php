<?php

namespace Mageleven\Career\Model\Allcareer\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $allCareer;

    public function __construct(\Mageleven\Career\Model\Allcareer $allCareer)
    {
        $this->allCareer = $allCareer;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->allCareer->getAvailableStatuses();
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

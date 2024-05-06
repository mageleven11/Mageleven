<?php
namespace Mageleven\Contributors\Model\Allcontactsupporttype\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $allContactsupporttype;

    public function __construct(\Mageleven\Contributors\Model\Allcontactsupporttype $allContactsupporttype)
    {
        $this->allContactsupporttype = $allContactsupporttype;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->allContactsupporttype->getAvailableStatuses();
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
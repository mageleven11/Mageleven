<?php

namespace Mageleven\Shopbrand\Model\ResourceModel\Shopbrand;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init('Mageleven\Shopbrand\Model\Shopbrand', 'Mageleven\Shopbrand\Model\ResourceModel\Shopbrand');
    }
}

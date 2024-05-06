<?php
namespace Mageleven\Shopbrand\Model\ResourceModel;

class Shopbrand extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('mageleven_shopbrand', 'shopbrand_id');
    }
}

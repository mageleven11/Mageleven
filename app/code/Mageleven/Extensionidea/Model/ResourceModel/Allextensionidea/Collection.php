<?php
namespace Mageleven\Extensionidea\Model\ResourceModel\Allextensionidea;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'me_id';
    
    protected $_eventPrefix = 'mageleven_extensionidea_grid_collection';

    protected $_eventObject = 'mageleven_extensionidea_collection';
    
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init('Mageleven\Extensionidea\Model\Allextensionidea', 'Mageleven\Extensionidea\Model\ResourceModel\Allextensionidea');
    }
}
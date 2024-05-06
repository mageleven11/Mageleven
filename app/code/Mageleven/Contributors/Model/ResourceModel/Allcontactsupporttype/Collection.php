<?php
namespace Mageleven\Contributors\Model\ResourceModel\Allcontactsupporttype;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'cs_id';
    
    protected $_eventPrefix = 'mageleven_contactsupporttype_grid_collection';

    protected $_eventObject = 'mageleven_contactsupporttype_collection';
    
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init('Mageleven\Contributors\Model\Allcontactsupporttype', 'Mageleven\Contributors\Model\ResourceModel\Allcontactsupporttype');
    }
}
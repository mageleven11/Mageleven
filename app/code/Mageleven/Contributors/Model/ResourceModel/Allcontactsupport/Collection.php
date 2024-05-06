<?php
namespace Mageleven\Contributors\Model\ResourceModel\Allcontactsupport;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 's_id';
    
    protected $_eventPrefix = 'mageleven_contactsupport_grid_collection';

    protected $_eventObject = 'mageleven_contactsupport_collection';
    
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init('Mageleven\Contributors\Model\Allcontactsupport', 'Mageleven\Contributors\Model\ResourceModel\Allcontactsupport');
    }
}
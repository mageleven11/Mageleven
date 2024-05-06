<?php
namespace Mageleven\Contributors\Model\ResourceModel\Allcontributors;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'mc_id';
    
    protected $_eventPrefix = 'mageleven_contributors_grid_collection';

    protected $_eventObject = 'mageleven_contributors_collection';
    
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init('Mageleven\Contributors\Model\Allcontributors', 'Mageleven\Contributors\Model\ResourceModel\Allcontributors');
    }
}
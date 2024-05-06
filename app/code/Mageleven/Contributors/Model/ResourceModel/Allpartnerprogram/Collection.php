<?php
namespace Mageleven\Contributors\Model\ResourceModel\Allpartnerprogram;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'pp_id';
    
    protected $_eventPrefix = 'mageleven_partnerprogram_grid_collection';

    protected $_eventObject = 'mageleven_partnerprogram_collection';
    
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init('Mageleven\Contributors\Model\Allpartnerprogram', 'Mageleven\Contributors\Model\ResourceModel\Allpartnerprogram');
    }
}
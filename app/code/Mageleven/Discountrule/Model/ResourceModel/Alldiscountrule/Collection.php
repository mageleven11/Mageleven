<?php
namespace Mageleven\Discountrule\Model\ResourceModel\Alldiscountrule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'discountrule_id';
	
	protected $_eventPrefix = 'discountrule_alldiscountrule_collection';

    protected $_eventObject = 'alldiscountrule_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('Mageleven\Discountrule\Model\Alldiscountrule', 'Mageleven\Discountrule\Model\ResourceModel\Alldiscountrule');
	}
}
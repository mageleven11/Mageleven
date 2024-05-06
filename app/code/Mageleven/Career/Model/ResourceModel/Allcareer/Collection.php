<?php
namespace Mageleven\Career\Model\ResourceModel\Allcareer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'career_id';
	
	protected $_eventPrefix = 'career_allcareer_collection';

    protected $_eventObject = 'allcareer_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('Mageleven\Career\Model\Allcareer', 'Mageleven\Career\Model\ResourceModel\Allcareer');
	}
}
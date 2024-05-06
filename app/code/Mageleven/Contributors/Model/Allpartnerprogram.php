<?php
namespace Mageleven\Contributors\Model;

use Magento\Framework\Model\AbstractModel;

class Allpartnerprogram extends AbstractModel
{

	const CACHE_TAG = 'mageleven_contributors';
	
	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;
	
	protected function _construct()
    {
        $this->_init('Mageleven\Contributors\Model\ResourceModel\Allpartnerprogram');
    }
	
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
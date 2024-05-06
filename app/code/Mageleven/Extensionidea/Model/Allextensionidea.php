<?php
namespace Mageleven\Extensionidea\Model;

use Magento\Framework\Model\AbstractModel;

class Allextensionidea extends AbstractModel
{
	const CACHE_TAG = 'mageleven_extensionidea';
	
	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;
	
	protected function _construct()
    {
        $this->_init('Mageleven\Extensionidea\Model\ResourceModel\Allextensionidea');
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
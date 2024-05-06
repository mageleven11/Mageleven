<?php
namespace Mageleven\Contributors\Model;

use Mageleven\Contributors\Api\Data\AllcontactsupporttypeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Allcontactsupporttype extends AbstractModel implements AllcontactsupporttypeInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

	const CACHE_TAG = 'mageleven_contributors';
	
	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;
	
	protected function _construct()
    {
        $this->_init('Mageleven\Contributors\Model\ResourceModel\Allcontactsupporttype');
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

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getId()
    {
        return parent::getData(self::CS_ID);
    }

    public function getType()
    {
        return $this->getData(self::TYPE);
    }

   
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function setId($id)
    {
        return $this->setData(self::CS_ID, $id);
    }

    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}
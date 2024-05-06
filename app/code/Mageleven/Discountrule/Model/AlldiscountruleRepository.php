<?php

namespace Mageleven\Discountrule\Model;

use Mageleven\Discountrule\Api\Data;
use Mageleven\Discountrule\Api\AlldiscountruleRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Mageleven\Discountrule\Model\ResourceModel\Alldiscountrule as ResourceAlldiscountrule;
use Mageleven\Discountrule\Model\ResourceModel\Alldiscountrule\CollectionFactory as AlldiscountruleCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class AlldiscountruleRepository implements AlldiscountruleRepositoryInterface
{
    protected $resource;

    protected $alldiscountruleFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataAlldiscountruleFactory;

    private $storeManager;

    public function __construct(
        ResourceAlldiscountrule $resource,
        AlldiscountruleFactory $alldiscountruleFactory,
        Data\AlldiscountruleInterfaceFactory $dataAlldiscountruleFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
		$this->alldiscountruleFactory = $alldiscountruleFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAlldiscountruleFactory = $dataAlldiscountruleFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\Mageleven\Discountrule\Api\Data\AlldiscountruleInterface $discountrule)
    {
        if ($discountrule->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $discountrule->setStoreId($storeId);
        }
        try {
            $this->resource->save($discountrule);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the discountrule: %1', $exception->getMessage()),
                $exception
            );
        }
        return $discountrule;
    }

    public function getById($discountruleId)
    {
		$discountrule = $this->alldiscountruleFactory->create();
        $discountrule->load($discountruleId);
        if (!$discountrule->getId()) {
            throw new NoSuchEntityException(__('Discountrule with id "%1" does not exist.', $discountruleId));
        }
        return $discountrule;
    }
	
    public function delete(\Mageleven\Discountrule\Api\Data\AlldiscountruleInterface $discountrule)
    {
        try {
            $this->resource->delete($discountrule);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the discountrule: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($discountruleId)
    {
        return $this->delete($this->getById($discountruleId));
    }
}

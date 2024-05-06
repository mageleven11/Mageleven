<?php

namespace Mageleven\Career\Model;

use Mageleven\Career\Api\Data;
use Mageleven\Career\Api\AllcareerRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Mageleven\Career\Model\ResourceModel\Allcareer as ResourceAllcareer;
use Mageleven\Career\Model\ResourceModel\Allcareer\CollectionFactory as AllcareerCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class AllcareerRepository implements AllcareerRepositoryInterface
{
    protected $resource;

    protected $allcareerFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataAllcareerFactory;

    private $storeManager;

    public function __construct(
        ResourceAllcareer $resource,
        AllcareerFactory $allcareerFactory,
        Data\AllcareerInterfaceFactory $dataAllcareerFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
		$this->allcareerFactory = $allcareerFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAllcareerFactory = $dataAllcareerFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\Mageleven\Career\Api\Data\AllcareerInterface $career)
    {
        if ($career->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $career->setStoreId($storeId);
        }
        try {
            $this->resource->save($career);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the career: %1', $exception->getMessage()),
                $exception
            );
        }
        return $career;
    }

    public function getById($careerId)
    {
		$career = $this->allcareerFactory->create();
        $career->load($careerId);
        if (!$career->getId()) {
            throw new NoSuchEntityException(__('Career with id "%1" does not exist.', $careerId));
        }
        return $career;
    }
	
    public function delete(\Mageleven\Career\Api\Data\AllcareerInterface $career)
    {
        try {
            $this->resource->delete($career);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the career: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($careerId)
    {
        return $this->delete($this->getById($careerId));
    }
}

<?php

namespace Mageleven\Contributors\Model;

use Mageleven\Contributors\Api\Data;
use Mageleven\Contributors\Api\AllcontactsupporttypeRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Mageleven\Contributors\Model\ResourceModel\Allcontactsupporttype as ResourceAllcontactsupporttype;
use Mageleven\Contributors\Model\ResourceModel\Allcontactsupporttype\CollectionFactory as AllcontactsupporttypeCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class AllcontactsupporttypeRepository implements AllcontactsupporttypeRepositoryInterface
{
    protected $resource;

    protected $allcontactsupporttypeFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataAllcontactsupporttypeFactory;

    private $storeManager;

    public function __construct(
        ResourceAllcontactsupporttype $resource,
        AllcontactsupporttypeFactory $allcontactsupporttypeFactory,
        Data\AllcontactsupporttypeInterfaceFactory $dataAllcontactsupporttypeFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->allcontactsupporttypeFactory = $allcontactsupporttypeFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAllcontactsupporttypeFactory = $dataAllcontactsupporttypeFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\Mageleven\Contributors\Api\Data\AllcontactsupporttypeInterface $contactsupporttype)
    {
        if ($contactsupporttype->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $contactsupporttype->setStoreId($storeId);
        }
        try {
            $this->resource->save($contactsupporttype);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the type: %1', $exception->getMessage()),
                $exception
            );
        }
        return $contactsupporttype;
    }

    public function getById($contactsupporttypeId)
    {
        $contactsupporttype = $this->allcontactsupporttypeFactory->create();
        $contactsupporttype->load($contactsupporttypeId);
        if (!$contactsupporttype->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $contactsupporttypeId));
        }
        return $contactsupporttype;
    }
    
    public function delete(\Mageleven\Contributors\Api\Data\AllcontactsupporttypeInterface $contactsupporttype)
    {
        try {
            $this->resource->delete($contactsupporttype);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the type: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($contactsupporttypeId)
    {
        return $this->delete($this->getById($contactsupporttypeId));
    }
}
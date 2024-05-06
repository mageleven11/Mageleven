<?php
namespace Mageleven\Contributors\Model\Allcontactsupporttype;

use Mageleven\Contributors\Model\ResourceModel\Allcontactsupporttype\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Mageleven\Contributors\Model\Allcontactsupporttype\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $allxmlimportCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $allcontactsupporttypeCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $allcontactsupporttypeCollectionFactory->create();
        
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $allxmls \Mageleven\Contributors\Model\allxmlimport */
        foreach ($items as $allxmls) {
            $this->loadedData[$allxmls->getId()] = $allxmls->getData();
        }

        $data = $this->dataPersistor->get('contributors_allcontactsupporttype');
        if (!empty($data)) {
            $allxmls = $this->collection->getNewEmptyItem();
            $allxmls->setData($data);
            $this->loadedData[$allxmls->getId()] = $allxmls->getData();
            $this->dataPersistor->clear('contributors_allcontactsupporttype');
        }

        return $this->loadedData;
    }
}

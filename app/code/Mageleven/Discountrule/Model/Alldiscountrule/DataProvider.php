<?php
namespace Mageleven\Discountrule\Model\Alldiscountrule;

use Mageleven\Discountrule\Model\ResourceModel\Alldiscountrule\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Mageleven\Discountrule\Model\ResourceModel\Alldiscountrule\Collection
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
     * @param CollectionFactory $alldiscountruleCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $alldiscountruleCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $alldiscountruleCollectionFactory->create();
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
        /** @var $discountrule \Mageleven\Discountrule\Model\Alldiscountrule */
        foreach ($items as $discountrule) {
            $this->loadedData[$discountrule->getId()] = $discountrule->getData();
        }

        $data = $this->dataPersistor->get('discountrule_alldiscountrule');
        if (!empty($data)) {
            $discountrule = $this->collection->getNewEmptyItem();
            $discountrule->setData($data);
            $this->loadedData[$discountrule->getId()] = $discountrule->getData();
            $this->dataPersistor->clear('discountrule_alldiscountrule');
        }

        return $this->loadedData;
    }
}

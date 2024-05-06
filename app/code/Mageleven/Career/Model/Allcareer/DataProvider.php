<?php
namespace Mageleven\Career\Model\Allcareer;

use Mageleven\Career\Model\ResourceModel\Allcareer\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Mageleven\Career\Model\ResourceModel\Allcareer\Collection
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
     * @param CollectionFactory $allcareerCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $allcareerCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $allcareerCollectionFactory->create();
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
        /** @var $career \Mageleven\Career\Model\Allcareer */
        foreach ($items as $career) {
            $this->loadedData[$career->getId()] = $career->getData();
            if($career->getData('image')){
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
                $mediaUrl = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

                $name = $career->getData('image');
                $m['image'][0]['name'] = $name;
                $m['image'][0]['url'] = $mediaUrl.'imageUploader/images/'.$name;
                $m['image'][0]['size'] = 2024;
                $this->loadedData[$career->getId()] = array_merge($career->getData(), $m);


                
            }
        }

        
        if (!empty($data)) {
            $career = $this->collection->getNewEmptyItem();
            $career->setData($data);
            $this->loadedData[$career->getId()] = $career->getData();
            $this->dataPersistor->clear('career_allcareer');
        }

       

        return $this->loadedData;
    }
}

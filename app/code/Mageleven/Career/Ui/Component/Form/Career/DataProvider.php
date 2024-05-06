<?php

namespace Mageleven\Career\Ui\Component\Form\Career;

use Magento\Store\Model\StoreManagerInterface;
use Mageleven\Career\Model\ResourceModel\Allcareer\Collection;
use Magento\Framework\App\RequestInterface;
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;
    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @var RequestInterface
     */
    protected $request;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        RequestInterface $request,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->request = $request;
        $this->storeManager = $storeManager;
    }
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!$this->loadedData) {
            $storeId = (int) $this->request->getParam('store');
            $this->collection->setStoreId($storeId)->addAttributeToSelect('*');
            $items = $this->collection->getItems();
            foreach ($items as $item) {
                $item->setStoreId($storeId);
                $itemData = $item->getData();
                if (isset($itemData['image'])) {
                    $imageName = explode('/', $itemData['image']);
                    $itemData['image'] = [
                        [
                            'name' => $imageName[3],
                            'url' => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'image/image' . $itemData['image'],
                        ],
                    ];
                } else {
                    $itemData['image'] = null;
                }
                
                $this->loadedData[$item->getEntityId()] = $itemData;
                break;
            }
        }
        return $this->loadedData;
    }
}
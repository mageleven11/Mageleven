<?php
namespace Mageleven\DeleteOrders\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Sales\Model\ResourceModel\OrderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Mageleven\DeleteOrders\Helper\AbstractData;

/**
 * Class Data
 * @package Mageleven\DeleteOrders\Helper
 */
class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'delete_orders';

    /**
     * @var OrderFactory
     */
     private $orderFactory;
    /**
     * Data constructor.
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param OrderFactory $orderFactory
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
         OrderFactory $orderFactory
    )
    {
        $this->orderFactory = $orderFactory;

        parent::__construct($context, $objectManager, $storeManager);
    }

    /**
     * @param $orderId
     */
    public function deleteRecord($orderId)
    {
        /** @var \Magento\Sales\Model\ResourceModel\Order $resource */
          $resource = $this->orderFactory->create();
        $connection = $resource->getConnection();

        /** delete invoice grid record via resource model*/
        $connection->delete(
            $resource->getTable('sales_invoice_grid'),
            $connection->quoteInto('order_id = ?', $orderId)
        );

        /** delete shipment grid record via resource model*/
        $connection->delete(
            $resource->getTable('sales_shipment_grid'),
            $connection->quoteInto('order_id = ?', $orderId)
        );

        /** delete creditmemo grid record via resource model*/
        $connection->delete(
            $resource->getTable('sales_creditmemo_grid'),
            $connection->quoteInto('order_id = ?', $orderId)
        );

        return;
    }
}
<?php
namespace Backend\DemoExtension\Model;

class Product extends \Magento\Catalog\Model\Product
{
    public function getBackendDemo()
    {
        // Add your logic here to get the backend demo URL for the product.
        // You can use $this to access product attributes and build the URL.
        return 'your_backend_demo_url';
    }
}

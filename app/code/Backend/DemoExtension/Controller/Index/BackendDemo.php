<?php
namespace Backend\DemoExtension\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Backend\DemoExtension\Model\Product;

class BackendDemo extends Action
{
    private $productModel;

    public function __construct(
        Context $context,
        Product $productModel
    ) {
        parent::__construct($context);
        $this->productModel = $productModel;
    }

    public function execute()
    {
        $result = [];
        $result['backend_demo_url'] = $this->productModel->getBackendDemo();
        $this->getResponse()->representJson($result);
    }
}

<?php
namespace Product\Custom\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class BackendDemoUrl extends Action
{
    protected $jsonFactory;
    protected $scopeConfig;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        JsonFactory $jsonFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute()
    {
        $url = $this->scopeConfig->getValue('catalog/product/backend_demo', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $resultJson = $this->jsonFactory->create();
        return $resultJson->setData(['url' => $url]);
    }
}

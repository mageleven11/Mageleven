<?php

namespace Product\Custom\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context as BackendContext;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\ActionInterface;

class Context extends BackendContext implements HttpGetActionInterface, CsrfAwareActionInterface, ActionInterface
{
    protected $resultPageFactory;

    public function __construct(
        BackendContext $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context->getEventDispatcher(), $context->getBackendHelper());
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @inheritdoc
     */
    public function createCsrfValidationException(
        RequestInterface $request
    ): ?InvalidRequestException {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        // The actual execution logic of your context class.
        // You can leave this method empty or implement the required logic.
    }
}

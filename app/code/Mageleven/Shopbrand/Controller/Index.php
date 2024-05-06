<?php
namespace Mageleven\Shopbrand\Controller;

abstract class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Magicproduct factory.
     *
     * @var \Mageleven\Shopbrand\Model\ShopbrandFactory
     */
    protected $_shopbrandFactory;

    protected $_resultPageFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context                                $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }
}

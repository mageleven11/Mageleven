<?php
namespace Manual\Form\Controller\Action;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Contact Form Page'));

        // Load your custom block
        $block = $resultPage->getLayout()->getBlock('content');
        $block->setTemplate('Manual_Form::form.phtml');

        return $resultPage;
    }
}

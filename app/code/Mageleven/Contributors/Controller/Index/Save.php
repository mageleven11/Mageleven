<?php
namespace Mageleven\Contributors\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

class Save extends Action
{
    protected $resultPageFactory;
    protected $allcontributorsFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Mageleven\Contributors\Model\AllcontributorsFactory $allcontributorsFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->allcontributorsFactory = $allcontributorsFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getPost();
            // echo "<pre>"; print_r($data); die;
            if ($data) {
                $model = $this->allcontributorsFactory->create();
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;

    }
}

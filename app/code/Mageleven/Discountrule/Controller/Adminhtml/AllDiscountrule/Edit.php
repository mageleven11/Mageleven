<?php

namespace Mageleven\Discountrule\Controller\Adminhtml\Alldiscountrule;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Mageleven_Discountrule::save');
	}

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Alldiscountrule
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Alldiscountrule $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mageleven_Discountrule::discountrule_alldiscountrule')
            ->addBreadcrumb(__('Discount Rule'), __('Discount Rule'))
            ->addBreadcrumb(__('Manage All Discount Rule'), __('Manage All Discount Rule'));
        return $resultPage;
    }

    /**
     * Edit Alldiscountrule
     *
     * @return \Magento\Backend\Model\View\Result\Alldiscountrule|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('discountrule_id');
        $model = $this->_objectManager->create(\Mageleven\Discountrule\Model\Alldiscountrule::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This discountrule no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('discountrule_alldiscountrule', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Alldiscountrule $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Discount Rule') : __('Add Discount Rule'),
            $id ? __('Edit Discount Rule') : __('Add Discount Rule')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Alldiscountrule'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Add Discount Rule'));

        return $resultPage;
    }
}

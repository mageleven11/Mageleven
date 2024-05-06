<?php

namespace Mageleven\Career\Controller\Adminhtml\Allcareer;

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
		return $this->_authorization->isAllowed('Mageleven_Career::save');
	}

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Allcareer
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Allcareer $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mageleven_Career::career_allcareer')
            ->addBreadcrumb(__('Career'), __('Career'))
            ->addBreadcrumb(__('Manage All Career'), __('Manage All Career'));
        return $resultPage;
    }

    /**
     * Edit Allcareer
     *
     * @return \Magento\Backend\Model\View\Result\Allcareer|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('career_id');
        $model = $this->_objectManager->create(\Mageleven\Career\Model\Allcareer::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This career no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('career_allcareer', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Allcareer $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Career') : __('Add Career'),
            $id ? __('Edit Career') : __('Add Career')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Allcareer'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Add Career'));

        return $resultPage;
    }
}

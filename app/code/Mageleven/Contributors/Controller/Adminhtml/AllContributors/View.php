<?php
namespace Mageleven\Contributors\Controller\Adminhtml\AllContributors;

class View extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;
	
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Mageleven\Contributors\Model\AllcontributorsFactory $allContributorsFactory
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->allContributorsFactory = $allContributorsFactory;
	}

	public function execute()
	{
		// $id = $this->getRequest()->getParam('mc_id');
		// $getContributor = $this->allContributorsFactory->create();
		// $collection = $getContributor->load($id);

		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend(__('View Contributor'));
		return $resultPage;
	}
}

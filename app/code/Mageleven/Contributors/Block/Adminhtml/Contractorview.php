<?php
namespace Mageleven\Contributors\Block\Adminhtml;

class Contractorview extends \Magento\Framework\View\Element\Template
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Mageleven\Contributors\Model\AllcontributorsFactory $allContributorsFactory,
        array $data = []
    )
    {
        $this->allContributorsFactory = $allContributorsFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get form action URL for POST booking request
     *
     * @return string
     */
    public function getContributorDetail()
    {
        $id = $this->getRequest()->getParam('mc_id');
        $getContributor = $this->allContributorsFactory->create();
        $collection = $getContributor->load($id);

        return $collection;
    }
}
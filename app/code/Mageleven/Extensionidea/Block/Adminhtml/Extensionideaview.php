<?php
namespace Mageleven\Extensionidea\Block\Adminhtml;

class Extensionideaview extends \Magento\Framework\View\Element\Template
{
    protected $resultPageFactory;
    protected $allExtensionideaFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Mageleven\Extensionidea\Model\Allextensionidea $allExtensionideaFactory,
        array $data = []
    )
    {
        $this->allExtensionideaFactory = $allExtensionideaFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get form action URL for POST booking request
     *
     * @return string
     */
    public function getExtensionideaDetail()
    {
        $id = $this->getRequest()->getParam('me_id');
        $getExtensionidea = $this->allExtensionideaFactory;
        $collection = $getExtensionidea->load($id);

        return $collection;
    }
}
<?php
namespace Mageleven\Extensionidea\Model;

use Magento\Framework\Model\AbstractModel;
use Mageleven\Extensionidea\Model\ResourceModel\Allextensionidea as AllextensionideaResourceModel;

class AllextensionideaFactory
{
    protected $objectManager;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function create(array $data = [])
    {
        return $this->objectManager->create(Allextensionidea::class, $data);
    }
}

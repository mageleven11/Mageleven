<?php
namespace Custom\Installationservice\Model;

class Customreview extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Custom\Installationservice\Model\ResourceModel\Customreview');
    }
}
?>
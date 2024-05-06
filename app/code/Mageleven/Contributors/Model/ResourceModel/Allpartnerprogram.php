<?php
namespace Mageleven\Contributors\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Allpartnerprogram extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }
    
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('mageleven_partnerprogram', 'pp_id');
    }
}
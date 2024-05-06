<?php
namespace Mageleven\Shopbrand\Block\Adminhtml;

class Brand extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_brand';
        $this->_blockGroup = 'Mageleven_Shopbrand';
        $this->_headerText = __('Brand');
        $this->_addButtonLabel = __('Add New Brand');
        parent::_construct();
    }
}

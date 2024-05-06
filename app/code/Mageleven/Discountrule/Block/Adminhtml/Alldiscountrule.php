<?php
namespace Mageleven\Discountrule\Block\Adminhtml;

class Alldiscountrule extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_alldiscountrule';
        $this->_blockGroup = 'Mageleven_Discountrule';
        $this->_headerText = __('Manage Discountrule');

        parent::_construct();

        if ($this->_isAllowedAction('Mageleven_Discountrule::save')) {
            $this->buttonList->update('add', 'label', __('Add Discountrule'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}

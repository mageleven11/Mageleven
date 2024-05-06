<?php
namespace Mageleven\Contributors\Block\Adminhtml;

class Allcontactsupporttype extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_allcontactsupporttype';
        $this->_blockGroup = 'Mageleven_Contributors';
        $this->_headerText = __('Manage Type');

        parent::_construct();

        if ($this->_isAllowedAction('Mageleven_Contributors::save')) {
            $this->buttonList->update('add', 'label', __('Add Type'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
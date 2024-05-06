<?php
namespace Mageleven\Career\Block\Adminhtml;

class Allcareer extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_allcareer';
        $this->_blockGroup = 'Mageleven_Career';
        $this->_headerText = __('Manage Career');

        parent::_construct();

        if ($this->_isAllowedAction('Mageleven_Career::save')) {
            $this->buttonList->update('add', 'label', __('Add Career'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}

<?php
namespace Custom\Installationservice\Block\Adminhtml\Customreview\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('customreview_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Customreview Information'));
    }
}
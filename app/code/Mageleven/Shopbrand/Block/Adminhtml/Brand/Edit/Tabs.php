<?php
namespace Mageleven\Shopbrand\Block\Adminhtml\Brand\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * construct.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('shopbrand_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Brand Information'));
    }

    // protected function _beforeToHtml()
    // {
    //     $this->addTab('general_section', array(
    //         'label'     => Mage::helper('adminhtml')->__('General Information'),
    //         'title'     => Mage::helper('adminhtml')->__('General Information'),
    //         'content'   => $this->getLayout()->createBlock('mageleven/adminhtml_manage_edit_tab_form')->toHtml(),
    //     ));       

    //     $reponsive = Mage::getSingleton('core/layout')->createBlock('mageleven/adminhtml_manage_edit_tab_reponsive');
    //     $reponsive->setId($this->getHtmlId() . '_content')->setElement($this); 
    //     $this->addTab('reponsive_section', array(
    //         'label'     => Mage::helper('adminhtml')->__('Reponsive'),
    //         'title'     => Mage::helper('adminhtml')->__('Reponsive'),
    //         'content'   => $reponsive->toHtml(),
    //     ));

    //     $config = Mage::getSingleton('core/layout')->createBlock('mageleven/adminhtml_manage_edit_tab_config');
    //     $config->setId($this->getHtmlId() . '_content')->setElement($this);   

    //     $this->addTab('config_section', array(
    //         'label'     => Mage::helper('adminhtml')->__('Config'),
    //         'title'     => Mage::helper('adminhtml')->__('Config'),
    //         'content'   => $config->toHtml(),
    //     ));

    //     return parent::_beforeToHtml();
    // }

}

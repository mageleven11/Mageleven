<?php
/**
 * Mageleven 
 * @category    Mageleven 
 * @copyright   Copyright (c) 2014 Mageleven (http://www.mageleven.net/) 
 * @license     http://www.mageleven.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-03-24 11:15:19
 * @@Function:
 */


namespace Mageleven\Testimonial\Block\Adminhtml\Testimonial\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * construct.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('testimonial_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Testimonial Information'));
    }

    // protected function _beforeToHtml()
    // {
    //     $this->addTab('general_section', array(
    //         'label'     => Mage::helper('adminhtml')->__('General Information'),
    //         'title'     => Mage::helper('adminhtml')->__('General Information'),
    //         'content'   => $this->getLayout()->createBlock('magicproduct/adminhtml_manage_edit_tab_form')->toHtml(),
    //     ));       

    //     $reponsive = Mage::getSingleton('core/layout')->createBlock('magicproduct/adminhtml_manage_edit_tab_reponsive');
    //     $reponsive->setId($this->getHtmlId() . '_content')->setElement($this); 
    //     $this->addTab('reponsive_section', array(
    //         'label'     => Mage::helper('adminhtml')->__('Reponsive'),
    //         'title'     => Mage::helper('adminhtml')->__('Reponsive'),
    //         'content'   => $reponsive->toHtml(),
    //     ));

    //     $config = Mage::getSingleton('core/layout')->createBlock('magicproduct/adminhtml_manage_edit_tab_config');
    //     $config->setId($this->getHtmlId() . '_content')->setElement($this);   

    //     $this->addTab('config_section', array(
    //         'label'     => Mage::helper('adminhtml')->__('Config'),
    //         'title'     => Mage::helper('adminhtml')->__('Config'),
    //         'content'   => $config->toHtml(),
    //     ));

    //     return parent::_beforeToHtml();
    // }

}

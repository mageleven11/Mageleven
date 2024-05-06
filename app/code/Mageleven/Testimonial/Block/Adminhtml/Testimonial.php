<?php
/**
 * Mageleven 
 * @category    Mageleven 
 * @copyright   Copyright (c) 2014 Mageleven (http://www.mageleven.net/) 
 * @license     http://www.mageleven.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-02-29 14:25:17
 * @@Function:
 */

namespace Mageleven\Testimonial\Block\Adminhtml;

class Testimonial extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_testimonial';
        $this->_blockGroup = 'Mageleven_Testimonial';
        $this->_headerText = __('Testimonial');
        $this->_addButtonLabel = __('Add New Testimonial');
        parent::_construct();
    }
}

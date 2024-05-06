<?php
/**
 * Mageleven 
 * @category 	Mageleven 
 * @copyright 	Copyright (c) 2014 Mageleven (http://www.mageleven.net/) 
 * @license 	http://www.mageleven.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-03-29 09:13:34
 * @@Function:
 */

namespace Mageleven\Testimonial\Controller\Adminhtml;

abstract class Index extends \Mageleven\Testimonial\Controller\Adminhtml\Testimonial
{
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Mageleven_Testimonial::testimonial_index');
    }
}

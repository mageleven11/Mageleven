<?php
/**
 * Mageleven 
 * @category    Mageleven 
 * @copyright   Copyright (c) 2014 Mageleven (http://www.mageleven.net/) 
 * @license     http://www.mageleven.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-03-29 15:35:32
 * @@Function:
 */

namespace Mageleven\Testimonial\Controller\Index;

class Index extends \Mageleven\Testimonial\Controller\Index
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

}

<?php
/**
 * Mageleven 
 * @category 	Mageleven 
 * @copyright 	Copyright (c) 2014 Mageleven (http://www.mageleven.net/) 
 * @license 	http://www.mageleven.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-22 16:53:42
 * @@Function:
 */

namespace Mageleven\Testimonial\Controller\Adminhtml\Index;

class NewAction extends \Mageleven\Testimonial\Controller\Adminhtml\Action
{
    public function execute()
    {
        $resultForward = $this->_resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}

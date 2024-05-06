<?php
/**
 * Mageleven 
 * @category    Mageleven 
 * @copyright   Copyright (c) 2014 Mageleven (http://www.mageleven.net/) 
 * @license     http://www.mageleven.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-11 23:15:05
 * @@Modify Date: 2020-05-31 15:52:06
 * @@Function:
 */

namespace Mageleven\Testimonial\Model\ResourceModel\Testimonial;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init('Mageleven\Testimonial\Model\Testimonial', 'Mageleven\Testimonial\Model\ResourceModel\Testimonial');
    }

    /**
     * set order by order and testimonial_id
     *
     * @return $this
     */
    public function setOrderByTestimonial()
    {
        $this->getSelect()->order(array('order asc', 'testimonial_id desc'));
        return $this;
    }

}

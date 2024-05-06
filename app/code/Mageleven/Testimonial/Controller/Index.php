<?php
/**
 * Mageleven 
 * @category    Mageleven 
 * @copyright   Copyright (c) 2014 Mageleven (http://www.mageleven.net/) 
 * @license     http://www.mageleven.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-03-29 14:48:08
 * @@Function:
 */


namespace Mageleven\Testimonial\Controller;

abstract class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Testimonial factory.
     *
     * @var \Mageleven\Magicproduct\Model\TestimonialFactory
     */
    protected $_testimonialFactory;

    protected $_resultPageFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context                                $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }
}

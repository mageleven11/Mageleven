<?php
/**
 * Mageleven 
 * @category    Mageleven 
 * @copyright   Copyright (c) 2014 Mageleven (http://www.mageleven.net/) 
 * @license     http://www.mageleven.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-22 16:54:00
 * @@Function:
 */

namespace Mageleven\Testimonial\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCsv extends \Mageleven\Testimonial\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'testimonials.csv';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Mageleven\Testimonial\Block\Adminhtml\Testimonial\Grid')->getCsv();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}

<?php
namespace Mageleven\Shopbrand\Controller\Adminhtml\Brand;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportExcel extends \Mageleven\Shopbrand\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'brands.xls';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Mageleven\Shopbrand\Block\Adminhtml\Brand\Grid')->getExcel();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}

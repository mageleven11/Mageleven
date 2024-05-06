<?php
namespace Mageleven\Shopbrand\Controller\Adminhtml\Brand;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCsv extends \Mageleven\Shopbrand\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'brands.csv';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Mageleven\Shopbrand\Block\Adminhtml\Brand\Grid')->getCsv();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}

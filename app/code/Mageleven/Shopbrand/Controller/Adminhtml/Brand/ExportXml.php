<?php
namespace Mageleven\Shopbrand\Controller\Adminhtml\Brand;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportXml extends \Mageleven\Shopbrand\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'brands.xml';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Mageleven\Shopbrand\Block\Adminhtml\Brand\Grid')->getXml();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}

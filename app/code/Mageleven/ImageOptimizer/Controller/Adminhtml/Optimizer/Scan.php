<?php
/**
 * @category  Mageleven
 * @package   Mageleven_ImageOptimizer
 * @author    Mageleven
 * @copyright Copyright (c) Mageleven (http://www.mageleven.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */

namespace Mageleven\ImageOptimizer\Controller\Adminhtml\Optimizer;

class Scan extends \Magento\Backend\App\Action
{
    /**
     * @var \Mageleven\ImageOptimizer\Helper\Data
     */
    public $dataHelper;
    
    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Mageleven\ImageOptimizer\Helper\Data $dataHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Mageleven\ImageOptimizer\Helper\Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
        
        parent::__construct($context);
    }
    
    /**
     * Scan and reindex action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        set_time_limit(18000);
        
        try {
            $this->dataHelper->scanAndReindex();
            
            $message = $this->messageManager->addSuccess(
                __('Scan and reindex operations completed successfully.')
            );
        } catch (\Exception $e) {
            $message = __('Scanning and reindexing failed.');
            $this->messageManager->addError($message);
            $this->messageManager->addError($e->getMessage());
        }
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        return $resultRedirect->setPath(
            'adminhtml/system_config/edit',
            ['section' => 'mageleven_imageoptimizer']
        );
    }
}

<?php
/**
 * @category  Mageleven
 * @package   Mageleven_ImageOptimizer
 * @author    Mageleven
 * @copyright Copyright (c) Mageleven (http://www.mageleven.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Mageleven\ImageOptimizer\Cron;

class Scan
{
    /**
     * @var \Mageleven\ImageOptimizer\Helper\Data
     */
    public $helper;
    
    /**
     * @var \Psr\Log\LoggerInterface
     */
    public $logger;
    
    /**
     * Constructor
     *
     * @param \Mageleven\ImageOptimizer\Helper\Data $helper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Mageleven\ImageOptimizer\Helper\Data $helper,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->helper = $helper;
        $this->logger = $logger;
    }
    
    /**
     * Cron method for executing scan and reindex process.
     */
    public function execute()
    {
        $extensionEnabled = (int) $this->helper->getConfig(
            'mageleven_imageoptimizer/general/enabled'
        );
        
        $cronJobEnabled = (int) $this->helper->getConfig(
            'mageleven_imageoptimizer/cron/enabled_scan'
        );
        
        if ($extensionEnabled && $cronJobEnabled) {
            try {
                $result = $this->helper->scanAndReindex();
                
                if ($result !== true) {
                    $mPrefix = 'Image Optimizer Cron: Scan and Reindex process';
                    $this->logger->debug($mPrefix . ' failed.');
                }
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }
    }
}

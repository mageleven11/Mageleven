<?php
/**
 * @category  Mageleven
 * @package   Mageleven_ImageOptimizer
 * @author    Mageleven
 * @copyright Copyright (c) Mageleven (http://www.mageleven.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Mageleven\ImageOptimizer\Cron;

class Optimize
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
     * Cron method for executing optmization process.
     */
    public function execute()
    {
        $extensionEnabled = (int) $this->helper->getConfig(
            'mageleven_imageoptimizer/general/enabled'
        );
        
        $cronJobEnabled = (int) $this->helper->getConfig(
            'mageleven_imageoptimizer/cron/enabled_optimize'
        );
        
        if ($extensionEnabled && $cronJobEnabled) {
            $mPrefix = 'Image Optimizer Cron: Optimization process ';
            if ($this->helper->isExecFunctionEnabled()) {
                try {
                    $result = $this->helper->optimize();
                    
                    if ($result !== true) {
                        $this->logger->debug($mPrefix . 'failed.');
                    }
                } catch (\Exception $e) {
                    $this->logger->critical($e);
                }
            } else {
                $this->logger->debug(
                    $mPrefix . 'failed because PHP exec() function is disabled.'
                );
            }
        }
    }
}

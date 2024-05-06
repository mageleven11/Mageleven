<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types = 1);

namespace Mageleven\LazyLoad\Observer;

use Mageleven\LazyLoad\Model\Config;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class LayoutLoadBeforeObserver used to add attribute to layout
 */
class LayoutLoadBeforeObserver implements ObserverInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * LayoutLoadBeforeObserver constructor.
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->config->getEnabled() && $this->config->isNoScriptEnabled()) {
            $layout = $observer->getLayout();
            $layout->getUpdate()->addHandle('mflazyzoad_no_js');
        }
    }
}

<?php
/**
 * Mageleven
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageleven.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageleven.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageleven
 * @package     Mageleven_BannerSlider
 * @copyright   Copyright (c) Mageleven (https://www.mageleven.com/)
 * @license     https://www.mageleven.com/LICENSE.txt
 */

namespace Mageleven\BannerSlider\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Registry;
use Mageleven\BannerSlider\Model\BannerFactory;

/**
 * Class Banner
 * @package Mageleven\BannerSlider\Controller\Adminhtml
 */
abstract class Banner extends Action
{
    /**
     * Banner Factory
     *
     * @var BannerFactory
     */
    protected $bannerFactory;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Result redirect factory
     *
     * @var RedirectFactory
     */

    /**
     * constructor
     *
     * @param BannerFactory $bannerFactory
     * @param Registry $coreRegistry
     * @param Context $context
     */
    public function __construct(
        BannerFactory $bannerFactory,
        Registry $coreRegistry,
        Context $context
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Init Banner
     *
     * @return \Mageleven\BannerSlider\Model\Banner
     */
    protected function initBanner()
    {
        $bannerId = (int)$this->getRequest()->getParam('banner_id');
        /** @var \Mageleven\BannerSlider\Model\Banner $banner */
        $banner = $this->bannerFactory->create();
        if ($bannerId) {
            $banner->load($bannerId);
        }
        $this->coreRegistry->register('mpbannerslider_banner', $banner);

        return $banner;
    }
}

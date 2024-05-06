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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Mageleven\BannerSlider\Model\SliderFactory;

/**
 * Class Slider
 * @package Mageleven\BannerSlider\Controller\Adminhtml
 */
abstract class Slider extends Action
{
    /**
     * Slider Factory
     *
     * @var SliderFactory
     */
    protected $sliderFactory;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Slider constructor.
     *
     * @param SliderFactory $sliderFactory
     * @param Registry $coreRegistry
     * @param Context $context
     */
    public function __construct(
        SliderFactory $sliderFactory,
        Registry $coreRegistry,
        Context $context
    ) {
        $this->sliderFactory = $sliderFactory;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Init Slider
     *
     * @return \Mageleven\BannerSlider\Model\Slider
     * @throws LocalizedException
     */
    protected function initSlider()
    {
        $sliderId = (int)$this->getRequest()->getParam('slider_id');
        /** @var \Mageleven\BannerSlider\Model\Slider $slider */
        $slider = $this->sliderFactory->create();
        if ($sliderId) {
            $slider->load($sliderId);
            if (!$slider->getId()) {
                throw new LocalizedException(__('The wrong slider is specified.'));
            }
        }
        $this->coreRegistry->register('mpbannerslider_slider', $slider);

        return $slider;
    }
}

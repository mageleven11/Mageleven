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

namespace Mageleven\BannerSlider\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Widget\Block\BlockInterface;
use Mageleven\BannerSlider\Model\Config\Source\Location;

/**
 * Class Widget
 * @package Mageleven\BannerSlider\Block
 */
class Widget extends Slider implements BlockInterface
{
    /**
     * @return array|AbstractCollection
     * @throws NoSuchEntityException
     */
    public function getBannerCollection()
    {
        $sliderId = $this->getData('slider_id');
        if (!$sliderId || !$this->helperData->isEnabled()) {
            return [];
        }

        $sliderCollection = $this->helperData->getActiveSliders();
        $slider           = $sliderCollection->addFieldToFilter('slider_id', $sliderId)
            ->addFieldToFilter('location', ['finset' => Location::USING_SNIPPET_CODE])->getFirstItem();
        
        $this->setSlider($slider);

        return parent::getBannerCollection();
    }
}

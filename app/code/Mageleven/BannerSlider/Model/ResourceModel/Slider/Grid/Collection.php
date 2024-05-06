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
 * @category  Mageleven
 * @package   Mageleven_BannerSlider
 * @copyright Copyright (c) Mageleven (https://www.mageleven.com/)
 * @license   https://www.mageleven.com/LICENSE.txt
 */

namespace Mageleven\BannerSlider\Model\ResourceModel\Slider\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Mageleven\BannerSlider\Model\ResourceModel\Slider;
use Psr\Log\LoggerInterface;

/**
 * Class Collection
 * @package Mageleven\BannerSlider\Model\ResourceModel\Slider\Grid
 */
class Collection extends SearchResult
{
    /**
     * ID Field Name
     *
     * @var string
     */
    protected $_idFieldName = 'slider_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'mageleven_bannerslider_slider_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'slider_collection';

    /**
     * Collection constructor.
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        $mainTable = 'mageleven_bannerslider_slider',
        $resourceModel = Slider::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    /**
     * @param array|string $field
     * @param null $condition
     *
     * @return Collection
     */
    public function addFieldToFilter($field, $condition = null)
    {
        switch ($field) {
            case 'banners':
                $field = 'main_table.name';
                break;
            case 'customer_group_ids':
                return parent::addFieldToFilter('customer_group_ids', ['finset' => $condition['eq']]);
            case 'store_ids':
                return parent::addFieldToFilter('store_ids', [['finset' => $condition['eq']], ['finset' => 0]]);
        }

        return parent::addFieldToFilter($field, $condition);
    }
}

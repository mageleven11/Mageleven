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
 * @package     Mageleven_BetterPopup
 * @copyright   Copyright (c) Mageleven (https://www.mageleven.com/)
 * @license     https://www.mageleven.com/LICENSE.txt
 */

namespace Mageleven\BetterPopup\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Newsletter\Model\ResourceModel\Subscriber\CollectionFactory;
use Mageleven\BetterPopup\Helper\Data as HelperData;
use Mageleven\BetterPopup\Model\Generate;

/**
 * Class Success
 * @package Mageleven\BetterPopup\Block
 */
class Success extends Popup
{

    /**
     * @var Generate
     */
    protected $generate;

    /**
     * Success constructor.
     * @param Context $context
     * @param HelperData $helperData
     * @param TimezoneInterface $localeDate
     * @param CollectionFactory $subscriberCollectionFactory
     * @param Generate $generate
     * @param array $data
     */
    public function __construct(
        Context $context,
        HelperData $helperData,
        TimezoneInterface $localeDate,
        CollectionFactory $subscriberCollectionFactory,
        Generate $generate,
        array $data = []
    ) {
        parent::__construct($context, $helperData, $localeDate, $subscriberCollectionFactory, $data);
        $this->generate = $generate;
    }

    /**
     * @var string
     */
    protected $_template = 'Mageleven_BetterPopup::popup/success.phtml';

    /**
     * @return string|string[]|null
     * @throws LocalizedException
     */
    public function getCouponCode()
    {
        $couponCode = '';
        if (!$this->_helperData->getWhatToShowConfig('popup_success/enable_coupon')) {
            return $couponCode;
        }
        $data = [
            'rule_id' => $this->_helperData->getWhatToShowConfig('popup_success/rule_id'),
            'coupon_pattern' => $this->_helperData->getWhatToShowConfig('popup_success/coupon_pattern'),
        ];

        return $this->generate->generateCoupon($data);
    }

    /**
     * Get Html Popup success
     *
     * @return mixed
     * @throws LocalizedException
     */
    public function getPopupSuccessContent()
    {
        $htmlConfig = $this->_helperData->getWhatToShowConfig('popup_success/html_success_content');

        return str_replace('{{coupon_code}}', $this->getCouponCode(), $htmlConfig);
    }
}

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
 * @package   Mageleven_SocialLogin
 * @copyright Copyright (c) Mageleven (https://www.mageleven.com/)
 * @license   https://www.mageleven.com/LICENSE.txt
 */

namespace Mageleven\SocialLogin\Block\DataDeletion;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mageleven\SocialLogin\Helper\Data as DataHelper;
use Mageleven\SocialLogin\Helper\Social as SocialHelper;

/**
 * Class DeleteData
 * @package Mageleven\SocialLogin\Block
 */
class DeleteData extends Template
{
    /**
     * @type DataHelper
     */
    protected $_helper;

    /**
     * @var SocialHelper
     */
    protected $_socialHelper;

    /**
     * DeleteData constructor.
     *
     * @param Context $context
     * @param DataHelper $helper
     * @param SocialHelper $socialHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        DataHelper $helper,
        SocialHelper $socialHelper,
        array $data = []
    ) {
        $this->_helper       = $helper;
        $this->_socialHelper = $socialHelper;

        parent::__construct($context, $data);
    }

    /**
     * @return DataHelper
     */
    public function helper()
    {
        return $this->_helper;
    }

    /**
     * Check can ShowConfirm
     */
    public function isShowConfirm()
    {
        $type = $this->getRequest()->getParam('type');
        try {
            if ($type && $this->_socialHelper->getDeleteDataUrl($type)) {
                return true;
            }
        } catch (LocalizedException $e) {

            return false;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getStoreName()
    {
        try {
            return $this->_storeManager->getStore()->getName();
        } catch (NoSuchEntityException $e) {
            return '';
        }
    }
}

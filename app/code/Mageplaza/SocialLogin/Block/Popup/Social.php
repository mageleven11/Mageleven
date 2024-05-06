<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category  Mageplaza
 * @package   Mageplaza_SocialLogin
 * @copyright Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license   https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\SocialLogin\Block\Popup;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mageplaza\SocialLogin\Helper\Social as SocialHelper;
use Mageplaza\SocialLogin\Model\System\Config\Source\Position;

/**
 * Class Social
 *
 * @package Mageplaza\SocialLogin\Block\Popup
 */
class Social extends Template
{
    /**
     * @type SocialHelper
     */
    protected $socialHelper;

    /**
     * @param Context $context
     * @param SocialHelper $socialHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        SocialHelper $socialHelper,
        array $data = []
    ) {
        $this->socialHelper = $socialHelper;

        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getAvailableSocials()
    {
        $availabelSocials = [];

        foreach ($this->socialHelper->getSocialTypes() as $socialKey => $socialLabel) {
            $this->socialHelper->setType($socialKey);
            if ($this->socialHelper->isEnabled()) {
                $availabelSocials[$socialKey] = [
                    'label'     => $socialLabel,
                    'login_url' => $this->getLoginUrl($socialKey),
                ];
            }
        }

        return $availabelSocials;
    }

    /**
     * @param $key
     *
     * @return string
     */
    public function getBtnKey($key)
    {
        switch ($key) {
            case 'vkontakte':
                $class = 'vk';
                break;
            default:
                $class = $key;
        }

        return $class;
    }

    /**
     * @return array
     */
    public function getSocialButtonsConfig()
    {
        $availableButtons = $this->getAvailableSocials();
        foreach ($availableButtons as $key => &$button) {
            $button['url']     = $this->getLoginUrl($key, ['authen' => 'popup']);
            $button['key']     = $key;
            $button['btn_key'] = $this->getBtnKey($key);
        }

        return $availableButtons;
    }

    /**
     * @param null $position
     *
     * @return bool
     */
    public function canShow($position = null)
    {
        $displayConfig = $this->socialHelper->getConfigGeneral('social_display');
        $displayConfig = explode(',', $displayConfig ?? '');

        if (!$position) {
            $controllerName = $this->getRequest()->getFullActionName();
            //echo $controllerName;
            //die;
            switch ($controllerName) {
                case 'customer_account_login':
                    $position = Position::PAGE_LOGIN;
                    break;
                case 'customer_account_forgotpassword':
                    $position = Position::PAGE_FORGOT_PASS;
                    break;
                case 'customer_account_create':
                    $position = Position::PAGE_CREATE;
                    break;
                case 'cms_index_index':
                    $position = Position::PAGE_LOGIN;
                    break;
                case 'catalog_category_view':
                    $position = Position::PAGE_LOGIN;
                    break;
                case 'catalog_product_view':
                    $position = Position::PAGE_LOGIN;
                    break;
                case 'checkout_cart_index':
                    $position = Position::PAGE_LOGIN;
                    break;
                default:
                    return false;
            }
        }
        // echo $this->getRequest()->getFullActionName();
        // die("sfdfd");
        //return $this->getRequest()->getFullActionName();

        return in_array($position, $displayConfig);
    }

    /**
     * @param $socialKey
     * @param array $params
     *
     * @return string
     */
    public function getLoginUrl($socialKey, $params = [])
    {
        $params['type'] = $socialKey;

        return $this->getUrl('sociallogin/social/login', $params);
    }
}

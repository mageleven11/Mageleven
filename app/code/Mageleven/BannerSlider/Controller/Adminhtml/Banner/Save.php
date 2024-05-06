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

namespace Mageleven\BannerSlider\Controller\Adminhtml\Banner;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Mageleven\BannerSlider\Controller\Adminhtml\Banner;
use Mageleven\BannerSlider\Helper\Image;
use Mageleven\BannerSlider\Model\BannerFactory;
use Mageleven\BannerSlider\Model\Config\Source\Type;
use RuntimeException;

/**
 * Class Save
 * @package Mageleven\BannerSlider\Controller\Adminhtml\Banner
 */
class Save extends Banner
{
    /**
     * JS helper
     *
     * @var Js
     */
    public $jsHelper;

    /**
     * Image Helper
     *
     * @var Image
     */
    protected $imageHelper;

    /**
     * Save constructor.
     *
     * @param Image $imageHelper
     * @param BannerFactory $bannerFactory
     * @param Registry $registry
     * @param Js $jsHelper
     * @param Context $context
     */
    public function __construct(
        Image $imageHelper,
        BannerFactory $bannerFactory,
        Registry $registry,
        Js $jsHelper,
        Context $context
    ) {
        $this->imageHelper = $imageHelper;
        $this->jsHelper = $jsHelper;

        parent::__construct($bannerFactory, $registry, $context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($this->getRequest()->getPost('banner')) {
            $data = $this->getRequest()->getPost('banner');
            $banner = $this->initBanner();
            if ($data['type'] === Type::IMAGE) {
                $this->imageHelper->uploadImage($data, 'image', Image::TEMPLATE_MEDIA_TYPE_BANNER, $banner->getImage());
            } else {
                $data['image'] = isset($data['image']['value']) ? $data['image']['value'] : '';
            }
            $data['sliders_ids'] = (isset($data['sliders_ids']) && $data['sliders_ids'])
                ? explode(',', $data['sliders_ids']) : [];
            if ($this->getRequest()->getPost('sliders', false)) {
                $banner->setTagsData(
                    $this->jsHelper->decodeGridSerializedInput($this->getRequest()->getPost('sliders', false))
                );
            }

            $banner->addData($data);

            $this->_eventManager->dispatch(
                'mpbannerslider_banner_prepare_save',
                [
                    'banner' => $banner,
                    'request' => $this->getRequest()
                ]
            );
            try {
                $banner->save();
                $this->messageManager->addSuccess(__('The Banner has been saved.'));
                $this->_session->setMagelevenBannerSliderBannerData(false);
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'mpbannerslider/*/edit',
                        [
                            'banner_id' => $banner->getId(),
                            '_current' => true
                        ]
                    );

                    return $resultRedirect;
                }
                $resultRedirect->setPath('mpbannerslider/*/');

                return $resultRedirect;
            } catch (RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Banner.'));
            }

            $this->_getSession()->setData('mageleven_bannerSlider_banner_data', $data);
            $resultRedirect->setPath(
                'mpbannerslider/*/edit',
                [
                    'banner_id' => $banner->getId(),
                    '_current' => true
                ]
            );

            return $resultRedirect;
        }

        $resultRedirect->setPath('mpbannerslider/*/');

        return $resultRedirect;
    }
}

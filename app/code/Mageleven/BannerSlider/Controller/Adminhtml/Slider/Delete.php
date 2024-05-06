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

namespace Mageleven\BannerSlider\Controller\Adminhtml\Slider;

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Mageleven\BannerSlider\Controller\Adminhtml\Slider;
use Mageleven\BannerSlider\Model\Banner;

/**
 * Class Delete
 * @package Mageleven\BannerSlider\Controller\Adminhtml\Slider
 */
class Delete extends Slider
{
    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            /** @var Banner $banner */
            $this->sliderFactory->create()
                ->load($this->getRequest()->getParam('slider_id'))
                ->delete();
            $this->messageManager->addSuccess(__('The slider has been deleted.'));
        } catch (Exception $e) {
            // display error message
            $this->messageManager->addErrorMessage($e->getMessage());
            // go back to edit form
            $resultRedirect->setPath(
                'mpbannerslider/*/edit',
                ['slider_id' => $this->getRequest()->getParam('slider_id')]
            );

            return $resultRedirect;
        }

        $resultRedirect->setPath('mpbannerslider/*/');

        return $resultRedirect;
    }
}

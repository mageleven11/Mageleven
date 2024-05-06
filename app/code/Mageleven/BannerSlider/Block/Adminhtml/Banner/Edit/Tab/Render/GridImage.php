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

namespace Mageleven\BannerSlider\Block\Adminhtml\Banner\Edit\Tab\Render;

use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\DataObject;
use Mageleven\BannerSlider\Model\Config\Source\Image as ImageModel;
use Mageleven\BannerSlider\Model\Config\Source\Type;

/**
 * Class GridImage
 * @package Mageleven\BannerSlider\Block\Adminhtml\Banner\Edit\Tab\Render
 */
class GridImage extends AbstractRenderer
{
    /**
     * @var ImageModel
     */
    protected $imageModel;

    /**
     * @var FilterProvider
     */
    protected $filterProvider;

    /**
     * GridImage constructor.
     *
     * @param Context $context
     * @param ImageModel $imageModel
     * @param FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        Context $context,
        ImageModel $imageModel,
        FilterProvider $filterProvider,
        array $data = []
    ) {
        $this->imageModel     = $imageModel;
        $this->filterProvider = $filterProvider;

        parent::__construct($context, $data);
    }

    /**
     * Render Banner Image
     *
     * @param DataObject $row
     *
     * @return string
     */
    public function render(DataObject $row)
    {
        if ($row->getData($this->getColumn()->getIndex())) {
            $imageUrl = $this->imageModel->getBaseUrl() . $row->getData($this->getColumn()->getIndex());

            return '<img src="' . $imageUrl . '" width=\'150\' class="admin__control-thumbnail"/>';
        } elseif ($row->getType() === Type::CONTENT) {
            return $this->filterProvider->getPageFilter()->filter($row->getContent());
        }

        return '';
    }
}

<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mageleven.com/Mageleven-License.txt
 *
 * @category   Mageleven
 * @package    Mageleven_HtmlSiteMap
 * @author     Extension Team
 * @copyright  Copyright (c) 2018-2019 Mageleven Commerce Co. ( http://bsscommerce.com )
 * @license    http://mageleven.com/Mageleven-License.txt
 */
namespace Mageleven\HtmlSitemap\Model\Config\Product;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class ExcludeHtmlSitemap extends AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [];
        $this->_options[] = ['label' => 'No', 'value' => '0'];
        $this->_options[] = ['label' => 'Yes', 'value' => '1'];
        return $this->_options;
    }
}


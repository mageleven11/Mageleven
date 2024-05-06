<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\HtmlSitemap\Block\Adminhtml\System\Config\Form;

class Info extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Return extension url
     * @return string
     */
    protected function getModuleUrl()
    {
        return 'https://mageleven.com/pub/magento-2-html-sitemap-extension?utm_source=m2admin_html_sitemap_config&utm_medium=link&utm_campaign=regular';
    }
    /**
     * Return extension title
     * @return string
     */
    protected function getModuleTitle()
    {
        return 'HTML Sitemap Extension';
    }
}

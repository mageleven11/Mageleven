<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\HtmlSitemap\Block;

class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * @var \Mageleven\HtmlSitemap\Model\Url
     */
    protected $_url;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Mageleven\HtmlSitemap\Model\Url $url
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\UrlInterface $url,
        array $data = []
    ) {
        $this->_url = $url;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->_url->getBaseUrl() . 'htmlsitemap';
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->_scopeConfig->getValue(
            \Mageleven\HtmlSitemap\Model\Config::XML_PATH_HOMEPAGE_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getOpenLinks()
    {
        return $this->_scopeConfig->getValue(
            \Mageleven\HtmlSitemap\Model\Config::XML_PATH_OPENLINKS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_scopeConfig->getValue(
            \Mageleven\HtmlSitemap\Model\Config::XML_PATH_EXTENSION_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            return '';
        }
        return parent::_toHtml();
    }
}

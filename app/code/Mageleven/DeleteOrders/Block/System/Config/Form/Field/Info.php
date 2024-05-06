<?php
namespace Mageleven\DeleteOrders\Block\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Info extends Field
{
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     * @codeCoverageIgnore
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '<div style="background: #EF432E;padding: 10px;border-radius: 5px;text-align: center">
                    <a target="_blank" href="https://www.mageleven.com/magento-extensions.html" style="color: #fff">Mageleven - Marketplace Extensions</a>
                </div>';
        
        return $html;
    }
}

<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */
namespace Mageleven\AutoRelatedProduct\Block\Adminhtml\Rule\Edit\WhereConditions;

use Magento\Framework\Data\Form\Element\AbstractElement;

class Where implements \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
    /**
     * @param AbstractElement $element
     * @return array|string|string[]
     */
    public function render(AbstractElement $element)
    {
        $html = '';

        if ($element->getRule() && $element->getRule()->getConditions()) {
            $html = str_replace('conditions', 'actions', $element->getRule()->getConditions()->asHtmlRecursive());
        }

        return $html;
    }
}

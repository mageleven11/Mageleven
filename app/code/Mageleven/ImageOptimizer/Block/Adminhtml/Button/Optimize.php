<?php
/**
 * @category  Mageleven
 * @package   Mageleven_ImageOptimizer
 * @author    Mageleven
 * @copyright Copyright (c) Mageleven (http://www.mageleven.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Mageleven\ImageOptimizer\Block\Adminhtml\Button;

use Magento\Framework\Data\Form\Element\AbstractElement;

class Optimize extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Retrieve element HTML markup
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function _getElementHtml(AbstractElement $element)
    {
        $element = null;
        
        /** @var \Magento\Backend\Block\Widget\Button $buttonBlock  */
        $buttonBlock = $this->getForm()->getLayout()
            ->createBlock(\Magento\Backend\Block\Widget\Button::class);
        
        $url = $this->getUrl("mageleven_imageoptimizer/optimizer/optimize");
            
        $data = [
            'class'   => 'mageleven-imageoptimizer-admin-button-optimize',
            'label'   => __('Start Optimization Process'),
            'onclick' => "setLocation('" . $url . "')",
        ];
        
        $html = $buttonBlock->setData($data)->toHtml();
        
        return $html;
    }
}

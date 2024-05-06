<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Mageleven\LazyLoad\Block\Adminhtml\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class DynamicRow extends AbstractFieldArray
{
    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('block_identifier', ['label' => __('Block Identifier'), 'style' => 'width:350px']);
        $this->addColumn('first_images_to_skip', ['label' => __('First Images To Skip'), 'style' => 'width:70px']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}

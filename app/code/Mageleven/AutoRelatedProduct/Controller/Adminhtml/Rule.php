<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Mageleven\AutoRelatedProduct\Controller\Adminhtml;

/**
 * Class Rule
 */
class Rule extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'autorp_rule_form_data';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'Mageleven_AutoRelatedProduct::rule';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = 'Mageleven\AutoRelatedProduct\Model\Rule';

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'Mageleven_AutoRelatedProduct::rule';

    /**
     * Status field name
     * @var string
     */
    protected $_statusField     = 'is_active';
}

<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Mageleven\AutoRelatedProduct\Api\Data;

/**
 * Interface RuleInterface
 * @package Mageleven\AutoRelatedProduct\Api\Data
 */
interface RuleInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ID = 'id';
    const RULE_ID = 'id';

    /**
     * Get customer group id's
     * @return string|null
     */
    public function getStoreIds();

    /**
     * Set customer group id's
     * @param string
     * @return mixed
     */
    public function setStoreIds($storeIds);

    /**
     * Set rule_id
     * @param string $ruleId
     * @return \Mageleven\AutoRelatedProduct\Api\Data\RuleInterface
     */
    public function setRuleId($ruleId);

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $id
     * @return \Mageleven\AutoRelatedProduct\Api\Data\RuleInterface
     */
    public function setId($id);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string
     * @return mixed
     */
    public function setName($name);
}

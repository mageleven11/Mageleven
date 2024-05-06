<?php
/**
 * Magezon
 *
 * This source file is subject to the Magezon Software License, which is available at http://magezon.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magezon.com for more information.
 *
 * @category  Magezon
 * @package   Magezon_CustomerApproval
 * @copyright Copyright (C) 2021 Magezon (http://magezon.com)
 */
namespace Magezon\CustomerApproval\Model\Attribute\Source;

/**
 * @api
 * @since 100.0.2
 */
class AdminList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\User\Model\ResourceModel\User\CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @param \Magento\User\Model\ResourceModel\User\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\User\Model\ResourceModel\User\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $colection = $this->collectionFactory->create();
        $users = [];
        foreach ($colection as $user) {
            $users[] = [
                'value' => $user->getId(),
                'label' => $user->getName() . ' (' . $user->getEmail() . ')'
            ];
        }
        return $users;
    }
}

<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */
namespace Mageleven\AdminUserGuide\Cron;

use Mageleven\AdminUserGuide\Model\XmlReader;

/**
 * Class XmlReader
 */
class XmlUpdate
{
    /**
     * @var XmlReader
     */
    private $xmlReader;

    /**
     * @param XmlReader $xmlReader
     */
    public function __construct(
        XmlReader $xmlReader
    ) {
        $this->xmlReader = $xmlReader;
    }

    /**
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        $this->xmlReader->update();
    }
}

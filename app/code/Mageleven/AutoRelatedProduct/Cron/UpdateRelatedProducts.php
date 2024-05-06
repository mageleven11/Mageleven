<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */
namespace Mageleven\AutoRelatedProduct\Cron;

use Mageleven\AutoRelatedProduct\Model\ResourceModel\RelatedUpdater;
use Mageleven\AutoRelatedProduct\Api\ConfigInterface as Config;

class UpdateRelatedProducts
{
    /**
     * @var RelatedUpdater
     */
    protected $relatedUpdater;

    /**
     * @var Config
     */
    protected $config;

    /**
     * BoughtUpdate constructor.
     * @param RelatedUpdater $relatedUpdater
     */
    public function __construct(
        RelatedUpdater $relatedUpdater,
        Config $config
    ) {
        $this->config = $config;
        $this->relatedUpdater = $relatedUpdater;
    }

    /**
     *
     */
    public function execute()
    {
        if ($this->config->isEnabled()) {
            $this->relatedUpdater->execute();
        }
    }
}

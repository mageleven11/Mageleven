<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types = 1);

namespace Mageleven\LazyLoad\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Mageleven\LazyLoad\Model\Config as Config;
use Magento\Config\Model\ResourceModel\Config as Resource;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;

class ConvertConfigToJsonPatch implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Resource
     */
    private $resource;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param Config $config
     * @param Resource $resource
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        Config $config,
        Resource $resource,
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->config = $config;
        $this->resource = $resource;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $connection = $this->moduleDataSetup->getConnection();
        $tableName = $this->moduleDataSetup->getTable('core_config_data');

        $query = $connection->select()
            ->from($tableName, ['config_id','value'])
            ->where(
                'path = ?',
                Config::XML_PATH_LAZY_BLOCKS
            )
            ->order('config_id ASC');

        $result = $connection->fetchAll($query);

        foreach ($result as $scope) {
            if (!isset($scope['config_id']) || !isset($scope['value'])) {
                continue;
            }

            $blocks = $this->getBlocks($scope['value']);
            if (empty($blocks)) {
                continue;
            }

            $jsonBlocks = $this->getJsonForBlocks($blocks);

            try {
                $connection->update(
                    $tableName,
                    ['value' => $jsonBlocks],
                    [
                        'config_id = ?' => $scope['config_id']
                    ]
                );
            } catch (\Exception $e) {
                $this->logger->debug(__('Mageleven LazyLoad ERROR: while converting to json for config_id: ') . $scope['config_id']);
                continue;
            }
        }

        $this->moduleDataSetup->endSetup();
    }

    /**
     * @param $block
     * @return string
     */
    protected function getNumberHashForBlock ($block): string {
        $numberHashFromString = sprintf('%u', crc32($block));
        $numberHashFromStringSuffix = substr($numberHashFromString, -3);

        return '_' . $numberHashFromString . $numberHashFromStringSuffix . '_' . $numberHashFromStringSuffix;
    }

    /**
     * @param $blocks
     * @return bool|string
     */
    protected function getJsonForBlocks($blocks)
    {
        $arrayBlocks = [];
        foreach ($blocks as $block) {
            $arrayBlocks[$this->getNumberHashForBlock($block)] =
                [
                    'block_identifier' => $block,
                    'first_images_to_skip' => ($block == 'category.products.list') ? '2' : '0'
                ];
        }

        return $this->serializer->serialize($arrayBlocks);
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @param $blocks
     * @return array
     */
    protected function getBlocks($blocks): array
    {
        json_decode($blocks);
        if (json_last_error() === JSON_ERROR_NONE) {
            return [];
        }

        $blocks = str_replace(["\r\n", "\n\r", "\n"], "\r", $blocks);
        $blocks = explode("\r", $blocks);
        $result = [];
        foreach ($blocks as $block) {
            if ($block = trim($block)) {
                $result[] = $block;
            }
        }

        return $result;
    }
}

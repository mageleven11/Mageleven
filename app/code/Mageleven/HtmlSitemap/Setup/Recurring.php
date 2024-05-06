<?php
/**
 * Copyright © Mageleven (support@mageleven.com). All rights reserved.
 * Please visit Mageleven.com for license details (https://mageleven.com/end-user-license-agreement).
 */

namespace Mageleven\HtmlSitemap\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class Recurring implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $setup->startSetup();
        $connection = $setup->getConnection();

        foreach (['mageleven_blog_post', 'mageleven_blog_category'] as $tableName) {
            $tableName = $setup->getTable($tableName);

            if ($connection->isTableExists($tableName) == true && !$connection->tableColumnExists($tableName, 'mf_exclude_html_sitemap')) {
                $columns = [
                    'mf_exclude_html_sitemap' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'nullable' => false,
                        'comment' => 'Exclude From HTML Sitemap',
                        'default' => '0'
                    ],
                ];

                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
            }
        }

        $setup->endSetup();
    }
}

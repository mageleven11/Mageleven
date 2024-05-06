<?php
namespace Itheavens\Fanpage\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Add Secondary Custom Content
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'custom_content',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => '2M',
                'nullable' => true,
                'comment' => 'Short Content'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'mageleven_solutions_home_group',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => '2M',
                'nullable' => true,
                'comment' => 'Mageleven Solutions Home Group'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'image',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => '2M',
                'nullable' => true,
                'comment' => 'Mageleven Solutions Home Group Image'
            ]
        );

        $installer->endSetup();
    }
}
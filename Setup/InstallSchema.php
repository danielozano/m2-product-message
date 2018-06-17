<?php

namespace Danielozano\ProductMessage\Setup;

use Danielozano\ProductMessage\Api\Data\MessageInterface;
use Danielozano\ProductMessage\Model\ResourceModel\Message;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /** @var \Magento\Framework\DB\Ddl\Table $table */
        $table = $installer->getConnection()->newTable(
            $installer->getTable(Message::TABLE_NAME)
        )->addColumn(
            MessageInterface::ID,
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Entity Id'
        )->addColumn(
            MessageInterface::PRODUCT_ID,
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Product Id'
        )->addColumn(
            MessageInterface::MESSAGE,
            Table::TYPE_TEXT,
            Table::DEFAULT_TEXT_SIZE,
            ['nullable' => false],
            'Message'
        )->addColumn(
            MessageInterface::CREATED_AT,
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            MessageInterface::UPDATED_AT,
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_UPDATE],
            'Updated At'
        );
        $installer->getConnection()->createTable($table);
        $setup->endSetup();
    }
}

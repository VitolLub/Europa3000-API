<?php

namespace Sample\Gridpart2\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface {

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;

        $installer->startSetup();
            $gridpart2template = $installer->getConnection()->newTable(
            $installer->getTable('api_synchronization'))
                ->addColumn(
                        'apisynchronization_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true), 'Code ID'
                )->addColumn(
                        'name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(), 'Name'
                )
                ->addColumn(
                            'dateupdate', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(), 'Last Date Update'
                )    
                ->addColumn(
                        'status', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 4, array('nullable' => false, 'default' => 1), 'Status'
                );
           $installer->getConnection()->createTable($gridpart2template);
        $installer->endSetup();
    }

}

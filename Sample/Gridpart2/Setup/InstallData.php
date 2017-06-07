<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Sample\Gridpart2\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface {

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        $setup->getConnection()->query("INSERT INTO api_synchronization SET `name` = 'Quantity synchronization', `dateupdate`='2017.04.19',`status`=1");
        $setup->getConnection()->query("INSERT INTO api_synchronization SET `name` = 'Export / Import - new product', `dateupdate`='2017.04.19',`status`=1");
        $setup->getConnection()->query("INSERT INTO api_synchronization SET `name` = 'Update product', `dateupdate`='2017.04.19',`status`=1");
        $setup->getConnection()->query("INSERT INTO api_synchronization SET `name` = 'Delete Product', `dateupdate`='2017.04.19',`status`=1");
        $setup->getConnection()->query("INSERT INTO api_synchronization SET `name` = 'Disable Product', `dateupdate`='2017.04.19',`status`=1");
        $setup->getConnection()->query("INSERT INTO api_synchronization SET `name` = 'Customer blocking', `dateupdate`='2017.04.19',`status`=1");
        $setup->getConnection()->query("INSERT INTO api_synchronization SET `name` = 'Export / Import - new customer', `dateupdate`='2017.04.19',`status`=1");
        $setup->getConnection()->query("INSERT INTO api_synchronization SET `name` = 'Update customer', `dateupdate`='2017.04.19',`status`=1");
    }

}

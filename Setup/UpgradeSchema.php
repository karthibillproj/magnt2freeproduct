<?php 
namespace Sapient\Freeproduct\Setup;
 
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
 
 
class UpgradeSchema implements UpgradeSchemaInterface
{
 
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $setup->startSetup();
            $setup->getConnection()->addColumn(
                $setup->getTable('salesrule'),
                'free_products',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'default' => 0,
                    'comment' => 'Free Products'
                ]
            );
            $setup->endSetup();
        }
    }
}
<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sapient\Freeproduct\Model\Rule\Action\Discount;

class CalculatorFactory extends \Magento\SalesRule\Model\Rule\Action\Discount\CalculatorFactory
{
 
    protected $_objectManager;

    /**
     * @var array
     */
    protected $classByType = [
        \Magento\SalesRule\Model\Rule::TO_PERCENT_ACTION => 'Magento\SalesRule\Model\Rule\Action\Discount\ToPercent',
        \Magento\SalesRule\Model\Rule::BY_PERCENT_ACTION => 'Magento\SalesRule\Model\Rule\Action\Discount\ByPercent',
        \Magento\SalesRule\Model\Rule::TO_FIXED_ACTION => 'Magento\SalesRule\Model\Rule\Action\Discount\ToFixed',
        \Magento\SalesRule\Model\Rule::BY_FIXED_ACTION => 'Magento\SalesRule\Model\Rule\Action\Discount\ByFixed',
        \Magento\SalesRule\Model\Rule::CART_FIXED_ACTION => 'Magento\SalesRule\Model\Rule\Action\Discount\CartFixed',
        \Magento\SalesRule\Model\Rule::BUY_X_GET_Y_ACTION => 'Magento\SalesRule\Model\Rule\Action\Discount\BuyXGetY',
        'freeproducts' => 'Sapient\Freeproduct\Model\Rule\Action\Discount\Freeproducts'
    ];

     public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, array $discountRules = [])
    {
        $this->classByType = array_merge($this->classByType, $discountRules);
        $this->_objectManager = $objectManager;
       parent::__construct($objectManager, $discountRules);
    }

    
    public function create($type)
    {
        if (!isset($this->classByType[$type])) {
            throw new \InvalidArgumentException($type . ' is unknown type');
        }

        return $this->_objectManager->create($this->classByType[$type]);
    }
}

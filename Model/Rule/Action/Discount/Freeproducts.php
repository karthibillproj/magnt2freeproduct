<?php
namespace Sapient\Freeproduct\Model\Rule\Action\Discount;

class Freeproducts extends \Magento\SalesRule\Model\Rule\Action\Discount\AbstractDiscount
{

    public function calculate($rule, $item, $qty)
    {
        /** @var \Magento\SalesRule\Model\Rule\Action\Discount\Data $discountData */
        $discountData = $this->discountFactory->create();
        return $discountData;
    }
}

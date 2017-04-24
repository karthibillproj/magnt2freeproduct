<?php

namespace Sapient\Freeproduct\Observer;

use Magento\Framework\Event\ObserverInterface;

class UpdateFreeObserver implements ObserverInterface {

    public function __construct(\Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Checkout\Model\Cart $cart
        ){
        $this->_productRepository = $productRepository;
        $this->cart = $cart;
    }



    public function execute(\Magento\Framework\Event\Observer $observer) {
        $info = $observer->getInfo()->toArray();
        $quote = $observer->getCart()->getQuote();
        foreach (array_keys($info) as $itemId) {
            $item = $quote->getItemById($itemId);
            if (!$item) 
                continue;
                
            if (!$item->getOptionByCode('sapientpromo_rule')) 
                continue;
                
            if (empty($info[$itemId]))
                continue;
                
            $info[$itemId]['remove'] = true;
        }
        
        return $this;
    }
}
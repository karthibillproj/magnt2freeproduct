<?php

namespace Sapient\Freeproduct\Observer;

use Magento\Framework\Event\ObserverInterface;

class InitiateFreeObserver implements ObserverInterface {

    public function __construct(\Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Checkout\Model\Cart $cart
        ){
        $this->_productRepository = $productRepository;
        $this->cart = $cart;
    }


    public function execute(\Magento\Framework\Event\Observer $observer) {
        $this->_isHandled = array();  
        $quote = $observer->getQuote();
        if (!$quote) 
            return $this;
            
        foreach ($quote->getItemsCollection() as $item) {
            if (!$item){
                continue;
            }
                
            if (!$item->getOptionByCode('sapientpromo_rule')){
                continue;
            }

            $this->cart->getQuote()->removeItem($item->getId());
        }
        return $this;
    }
}
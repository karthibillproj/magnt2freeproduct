<?php

namespace Sapient\Freeproduct\Observer;

use Magento\Framework\Event\ObserverInterface;

class ValidatorObserver implements ObserverInterface {

	protected $_productRepository;
    protected $_isHandled = array();

    public function __construct(\Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Checkout\Model\Cart $cart
        ){
        $this->_productRepository = $productRepository;
        $this->cart = $cart;

    }


    public function execute(\Magento\Framework\Event\Observer $observer) {
      
         $rule = $observer->getEvent()->getData('rule');
    
         if ($rule->getSimpleAction() == 'freeproducts') {
       
             if (isset($this->_isHandled[$rule->getId()])){
                return $this;
             }

            $this->_isHandled[$rule->getId()] = true;
            $freeproduct = $rule->getData('free_products');
            
            if (!$freeproduct){
                return $this;     
            }  
        
             $product = $this->_getProduct($freeproduct);

             if (!$product){
                continue;
             }

             $item = $observer->getEvent()->getItem();
             $quote = $observer->getEvent()->getQuote();

            // $qty = $product->getQty();
             $qty = $this->_getFreeItemsQty($rule, $quote);

             $this->addproducttoquote($quote, $product, $qty, $rule);

         }
    }

    protected function addproducttoquote($quote, $product, $qty, $rule){

            $product->addCustomOption('sapientpromo_rule', $rule->getId());
            
            $item  = $quote->getItemByProduct($product);
           
            if($item) {  
                return false;       
            }

             $item = $this->cart->getQuote()->addProduct($product, $qty);

            $item->setCustomPrice(0); 
            $item->setOriginalCustomPrice(0);
            $item->setMessage('FREE');
            $this->cart->save();
    }

     protected function _getProduct($sku){
        $product = $this->_productRepository->get($sku);
        return $product;
    }

     protected function _getFreeItemsQty($rule, $quote)
    {  
        $qty    = 0;
        $itemarray = array();
        foreach ($quote->getItemsCollection() as $item) {
            if (!$item) 
                continue;
                
            if ($item->getOptionByCode('sapientpromo_rule')) 
                continue;
                
            if (!$rule->getActions()->validate($item)) {
                continue;
            }
            if ($item->getParentItemId()) {
                continue;
            } 

            if(in_array($item->getSku(), $itemarray)){
                continue;
            }
            $itemarray[] =   $item->getSku();

           $qty = $qty + $item->getQty();
         
        }  

        return $qty;        
    }  

   
}
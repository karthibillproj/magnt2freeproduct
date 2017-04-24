<?php

namespace Sapient\Freeproduct\Plugin;

class RendererPlugin
{    
 

    public function aftergetActions(\Magento\Checkout\Block\Cart\Item\Renderer $subject, $result)
    {

         $item = $subject->getItem();
        if ($item->getOptionByCode('sapientpromo_rule')){
                return '';
        }else{
            return $result;
        }

       // return $item->getName().'sddd'.$result;
    }
}
?>
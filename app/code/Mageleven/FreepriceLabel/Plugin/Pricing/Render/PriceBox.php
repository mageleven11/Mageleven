<?php
namespace Mageleven\FreepriceLabel\Plugin\Pricing\Render;
 
use Magento\Framework\Pricing\Amount\AmountInterface;
 
class PriceBox
{
   public function aroundRenderAmount(
       \Magento\Framework\Pricing\Render\PriceBox $subject,
       \Closure $proceed,
       AmountInterface $amount,
       array $arguments = []
   ) {
       if ($subject->getPrice()->getValue() == 0) {
           return '<div class="mg_free_product">Free</div>';
       }
       return $proceed($amount, $arguments);
   }
}
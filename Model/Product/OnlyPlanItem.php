<?php
namespace PlugHacker\PlugPagamentos\Model\Product;

use Magento\Catalog\Model\Product\Type\AbstractType;
use Magento\Catalog\Model\Product;

class OnlyPlanItem extends AbstractType
{
    public function deleteTypeSpecificData( Product $product)
    {
    }
}

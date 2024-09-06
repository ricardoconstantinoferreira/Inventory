<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Model\ResourceModel\InventoryPrice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RCFerreira\InventoryPrice\Model\ResourceModel\InventoryPrice as ResourceModelInventoryPrice;
use RCFerreira\InventoryPrice\Model\InventoryPrice;

class Collection extends AbstractCollection
{

    public function _construct()
    {
        $this->_init(InventoryPrice::class, ResourceModelInventoryPrice::class);
    }
}

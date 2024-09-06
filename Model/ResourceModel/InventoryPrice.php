<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use RCFerreira\InventoryPrice\Api\Data\InventoryPriceInterface;

class InventoryPrice extends AbstractDb
{
    public function _construct()
    {
        $this->_init(InventoryPriceInterface::TABLE, InventoryPriceInterface::ENTITY_ID);
    }
}

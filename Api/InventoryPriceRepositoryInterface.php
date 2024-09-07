<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Api;

use RCFerreira\InventoryPrice\Api\Data\InventoryPriceInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface InventoryPriceRepositoryInterface
{
    /**
     * @param InventoryPriceInterface $inventoryPrice
     * @return int
     */
    public function save(InventoryPriceInterface $inventoryPrice): int;

    /**
     * @param int $id
     * @return InventoryPriceInterface
     */
    public function getById(int $id): InventoryPriceInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return array
     */
    public function getList(SearchCriteriaInterface $searchCriteria): array;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param InventoryPriceInterface $inventoryPrice
     * @return bool
     */
    public function delete(InventoryPriceInterface $inventoryPrice): bool;
}

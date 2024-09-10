<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Model\Data;

use Magento\Framework\Api\SearchCriteriaBuilder;
use RCFerreira\InventoryPrice\Api\InventoryPriceRepositoryInterface;

class InventoryData
{

    /**
     * @param InventoryPriceRepositoryInterface $inventoryPriceRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        private InventoryPriceRepositoryInterface $inventoryPriceRepository,
        private SearchCriteriaBuilder $searchCriteriaBuilder
    ) {}

    /**
     * @return array
     */
    public function getData(): array
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->inventoryPriceRepository->getList($searchCriteria);
    }
}

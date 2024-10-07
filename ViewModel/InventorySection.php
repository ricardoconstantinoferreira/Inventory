<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use RCFerreira\InventoryPrice\Model\Data\InventoryData;

class InventorySection implements ArgumentInterface
{
    /**
     * @param InventoryData $inventoryData
     */
    public function __construct(
        private InventoryData $inventoryData
    ) {}

    /**
     * @return array[]
     */
    public function getSectionData(): array
    {
        $availableOptions = [];
        $values = $this->inventoryData->getData();

        if (!empty($values)) {
            foreach ($values as $value) {
                $availableOptions[] = [
                    'key' => $value['entity_id'],
                    'value' => $value['name'],
                    'percentage' => $value['percentage']
                ];
            }
        }

        return $availableOptions;
    }
}

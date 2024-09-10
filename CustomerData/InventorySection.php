<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use RCFerreira\InventoryPrice\Model\Data\InventoryData;

class InventorySection implements SectionSourceInterface
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
                    'value' => $value['name']
                ];
            }
        }

        return [
            'options' => $availableOptions
        ];
    }
}

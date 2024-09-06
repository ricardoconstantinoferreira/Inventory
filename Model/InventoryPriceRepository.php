<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use RCFerreira\InventoryPrice\Api\Data\InventoryPriceInterface;
use RCFerreira\InventoryPrice\Api\InventoryPriceRepositoryInterface;
use RCFerreira\InventoryPrice\Model\ResourceModel\InventoryPrice as ResourceModelInventoryPrice;
use RCFerreira\InventoryPrice\Model\ResourceModel\InventoryPrice\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use RCFerreira\InventoryPrice\Api\Data\InventoryPriceSearchResultsInterfaceFactory;

class InventoryPriceRepository implements InventoryPriceRepositoryInterface
{

    public function __construct(
        private ResourceModelInventoryPrice $resourceModelInventoryPrice,
        private CollectionFactory $collectionFactory,
        private CollectionProcessorInterface $collectionProcessor,
        private InventoryPriceSearchResultsInterfaceFactory $inventoryPriceSearchResults,
        private InventoryPriceFactory $inventoryPriceFactory
    ) {}

    /**
     * @param InventoryPriceInterface $inventoryPrice
     * @return int
     * @throws CouldNotSaveException
     */
    public function save(InventoryPriceInterface $inventoryPrice): int
    {
        try {
            $this->resourceModelInventoryPrice->save($inventoryPrice);
            return (int) $inventoryPrice->getId();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Error to save inventory'));
        }
    }

    /**
     * @param int $id
     * @return InventoryPriceInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): InventoryPriceInterface
    {
        $inventoryPrice = $this->inventoryPriceFactory->create();
        $this->resourceModelInventoryPrice->load($inventoryPrice, $id);

        if (!$inventoryPrice->getId()) {
            throw new NoSuchEntityException(__('The inventory with the "%1" ID doesn\'t exist.', $id));
        }

        return $inventoryPrice;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return array
     */
    public function getList(SearchCriteriaInterface $searchCriteria): array
    {
        $items = [];

        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->inventoryPriceSearchResults->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        if (!empty($searchResults->getItems())) {
            foreach ($searchResults->getItems() as $item) {
                $items[] = $item->getData();
            }
        }

        return $items;
    }

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param InventoryPriceInterface $inventoryPrice
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(InventoryPriceInterface $inventoryPrice): bool
    {
        try {
            $this->resourceModelInventoryPrice->delete($inventoryPrice);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }
}

<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Block\Adminhtml\Block\Edit;

use Magento\Backend\Block\Widget\Context;
use RCFerreira\InventoryPrice\Api\InventoryPriceRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @param Context $context
     * @param InventoryPriceRepositoryInterface $inventoryPriceRepository
     */
    public function __construct(
        private Context $context,
        private InventoryPriceRepositoryInterface $inventoryPriceRepository
    ) {}

    /**
     * @return mixed|null
     */
    public function getEntityId()
    {
        try {
            return $this->inventoryPriceRepository->getById(
                (int) $this->context->getRequest()->getParam('entity_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * @param $route
     * @param $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}


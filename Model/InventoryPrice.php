<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Model;

use RCFerreira\InventoryPrice\Api\Data\InventoryPriceInterface;
use Magento\Framework\Model\AbstractModel;

class InventoryPrice extends AbstractModel implements InventoryPriceInterface
{

    public function _construct()
    {
        $this->_init(\RCFerreira\InventoryPrice\Model\ResourceModel\InventoryPrice::class);
    }

    /**
     * @inheritDoc
     */
    public function setId($entity_id)
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): InventoryPriceInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setAddress(string $address): InventoryPriceInterface
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * @inheritDoc
     */
    public function getAddress(): string
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setSku(string $sku): InventoryPriceInterface
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * @inheritDoc
     */
    public function getSku(): string
    {
        return $this->getData(self::SKU);
    }

    /**
     * @inheritDoc
     */
    public function setPostcode(string $postcode): InventoryPriceInterface
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    /**
     * @inheritDoc
     */
    public function getPostcode(): string
    {
        return $this->getData(self::POSTCODE);
    }

    /**
     * @param int $percentage
     * @return InventoryPriceInterface
     */
    public function setPercentage(int $percentage): InventoryPriceInterface
    {
        return $this->setData(self::PERCENTAGE, $percentage);
    }

    /**
     * @return int
     */
    public function getPercentage(): int
    {
        return $this->getData(self::PERCENTAGE);
    }
}

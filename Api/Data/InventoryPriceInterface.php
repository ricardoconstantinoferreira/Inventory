<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Api\Data;

interface InventoryPriceInterface
{

    public const TABLE = "rcferreira_inventory_price";

    public const ENTITY_ID = "entity_id";

    public const NAME = "name";

    public const ADDRESS = "address";

    public const SKU = "sku";

    public const POSTCODE = "postcode";

    /**
     * @param $entity_id
     * @return mixed
     */
    public function setId($entity_id);

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $name
     * @return InventoryPriceInterface
     */
    public function setName(string $name): InventoryPriceInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $address
     * @return InventoryPriceInterface
     */
    public function setAddress(string $address): InventoryPriceInterface;

    /**
     * @return string
     */
    public function getAddress(): string;

    /**
     * @param string $sku
     * @return InventoryPriceInterface
     */
    public function setSku(string $sku): InventoryPriceInterface;

    /**
     * @return string
     */
    public function getSku(): string;

    /**
     * @param string $postcode
     * @return InventoryPriceInterface
     */
    public function setPostcode(string $postcode): InventoryPriceInterface;

    /**
     * @return string
     */
    public function getPostcode(): string;
}

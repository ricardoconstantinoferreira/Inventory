<?php

declare(strict_types=1);

namespace RCFerreira\InventoryPrice\Model\Validate;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class ProductValidation
{

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private SearchCriteriaBuilder $searchCriteriaBuilder
    ) {}

    /**
     * @param string $dataSku
     * @return int
     */
    public function hasProduct(string $dataSku): int
    {
        $skus = explode(",", $dataSku);
        $cont = 0;

        foreach ($skus as $sku) {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('sku', $sku)
                ->create();
            $product = $this->productRepository->getList($searchCriteria);

            if (empty($product->getItems())) {
                $cont++;
            }
        }

        return $cont;
    }
}

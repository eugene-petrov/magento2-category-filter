<?php

declare(strict_types=1);

namespace ReadyToGo\CategoryFilter\Model\ResourceModel;

use Magento\Framework\App\ResourceConnection;

class CategoryManager
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param array $categoryIds
     * @return array
     */
    public function getProductIdsByCategoryIds(array $categoryIds): array
    {
        $connection = $this->resourceConnection->getConnection();

        $select = $connection->select();
        $select->from($connection->getTableName('catalog_category_product'), ['product_id']);
        $select->where('category_id IN (?)', $categoryIds);

        return $connection->fetchCol($select);
    }

    /**
     * @param array $productIds
     * @return array
     */
    public function getSkuByProductIds(array $productIds): array
    {
        $connection = $this->resourceConnection->getConnection();
        $select = $connection->select();
        $select->from($connection->getTableName('catalog_product_entity'), ['sku']);
        $select->where('entity_id IN (?)', $productIds);

        return $connection->fetchCol($select);
    }
}

<?php

declare(strict_types=1);

namespace ReadyToGo\CategoryFilter\Plugin\Magento\Elasticsearch\Model\Adapter\BatchDataMapper\ProductDataMapper;

use Magento\Elasticsearch\Model\Adapter\BatchDataMapper\ProductDataMapper;

class AddSkuDataMapper
{
    private const FIELD_NAME_SKU = 'sku_value';
    private const DOCUMENT_FIELD_NAME_SKU = 'sku';

    /**
     * @param ProductDataMapper $subject
     * @param callable $proceed
     * @param array $documentData
     * @param int $storeId
     * @param array $context
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundMap(
        ProductDataMapper $subject,
        callable $proceed,
        array $documentData,
        int $storeId,
        array $context = []
    ): array {
        $documentData = $proceed($documentData, $storeId, $context);
        foreach ($documentData as $productId => $document) {
            $document[self::FIELD_NAME_SKU] = $document[self::DOCUMENT_FIELD_NAME_SKU];
            $documentData[$productId] = $document;
        }

        return $documentData;
    }
}

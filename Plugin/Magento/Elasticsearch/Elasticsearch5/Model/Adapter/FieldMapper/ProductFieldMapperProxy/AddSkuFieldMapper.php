<?php

declare(strict_types=1);

// phpcs:disable Generic.Files.LineLength.TooLong
namespace ReadyToGo\CategoryFilter\Plugin\Magento\Elasticsearch\Elasticsearch5\Model\Adapter\FieldMapper\ProductFieldMapperProxy;

use Magento\Elasticsearch\Elasticsearch5\Model\Adapter\FieldMapper\ProductFieldMapperProxy;

class AddSkuFieldMapper
{
    private const FIELD_NAME_SKU_VALUE = 'sku_value';
    private const FIELD_NAME_SKU = 'sku';
    private const DATA_TYPE_KEYWORD = 'keyword';
    private const DATA_TYPE_TEXT = 'text';

    /**
     * @param ProductFieldMapperProxy $subject
     * @param array $result
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetAllAttributesTypes(ProductFieldMapperProxy $subject, array $result): array
    {
        $result[self::FIELD_NAME_SKU_VALUE] = ['type' => self::DATA_TYPE_KEYWORD];
        $result[self::FIELD_NAME_SKU] = ['type' => self::DATA_TYPE_TEXT, 'fielddata' => true];

        return $result;
    }
}

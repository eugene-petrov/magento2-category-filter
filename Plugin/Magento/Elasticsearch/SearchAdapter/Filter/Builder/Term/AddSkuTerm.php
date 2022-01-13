<?php

declare(strict_types=1);

namespace ReadyToGo\CategoryFilter\Plugin\Magento\Elasticsearch\SearchAdapter\Filter\Builder\Term;

use Magento\Elasticsearch\Model\Adapter\FieldMapper\FieldMapperResolver;
use Magento\Elasticsearch\SearchAdapter\Filter\Builder\Term;
use Magento\Framework\Search\Request\FilterInterface;

class AddSkuTerm
{
    private const SKU_FIELD = 'sku';

    /**
     * @var FieldMapperResolver
     */
    private $fieldMapper;

    /**
     * @param FieldMapperResolver $fieldMapper
     */
    public function __construct(FieldMapperResolver $fieldMapper)
    {
        $this->fieldMapper = $fieldMapper;
    }

    /**
     * @param Term $subject
     * @param callable $proceed
     * @param FilterInterface $filter
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundBuildFilter(
        Term $subject,
        callable $proceed,
        FilterInterface $filter
    ): array {
        if ($this->fieldMapper->getFieldName($filter->getField()) != self::SKU_FIELD) {
            return $proceed($filter);
        }

        $filterQuery = [];
        if ($filter->getValue()) {
            $operator = is_array($filter->getValue()) ? 'terms' : 'term';
            $filterQuery[] = [
                $operator => [
                    $this->fieldMapper->getFieldName($filter->getField()) . '_value' => $filter->getValue(),
                ],
            ];
        }

        return $filterQuery;
    }
}

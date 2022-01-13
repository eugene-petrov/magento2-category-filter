<?php

declare(strict_types=1);

namespace ReadyToGo\CategoryFilter\Plugin\Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection;

use Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection;
use Magento\Framework\App\RequestInterface;
use ReadyToGo\CategoryFilter\Model\ResourceModel\CategoryManager;

class AddProductsFilter
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var CategoryManager
     */
    private $categoryManager;

    /**
     * @param RequestInterface $request
     * @param CategoryManager $categoryManager
     */
    public function __construct(RequestInterface $request, CategoryManager $categoryManager)
    {
        $this->request = $request;
        $this->categoryManager = $categoryManager;
    }

    /**
     * @param Collection $subject
     * @param Collection $result
     * @return Collection
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterAddCategoryFilter(Collection $subject, Collection $result): Collection
    {
        $catIds = $this->request->getParam('cat_ids');
        if (!$catIds) {
            return $result;
        }

        $catIds = explode(',', $catIds);
        $productIds = $this->categoryManager->getProductIdsByCategoryIds($catIds);
        $skuList = $this->categoryManager->getSkuByProductIds($productIds);
        $result->addFieldToFilter('sku', $skuList);

        return $result;
    }
}

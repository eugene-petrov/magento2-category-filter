<?php

declare(strict_types=1);

namespace ReadyToGo\CategoryFilter\Plugin\Magento\Catalog\Model\Layer\Category\CollectionFilter;

use ReadyToGo\CategoryFilter\Model\ResourceModel\CategoryManager;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Layer\Category\CollectionFilter;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\App\RequestInterface;

class CategoryFilter
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
     * @param CollectionFilter $subject
     * @param null $result
     * @param Collection $collection
     * @param Category $category
     * @return null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterFilter(
        CollectionFilter $subject,
        $result,
        Collection $collection,
        Category $category
    ) {
        $catIds = $this->request->getParam('cat_ids');
        if (!$catIds) {
            return $result;
        }

        $catIds = explode(',', $catIds);
        $productIds = $this->categoryManager->getProductIdsByCategoryIds($catIds);
        $collection->getSelect()->where('e.entity_id IN (?)', $productIds);

        return $result;
    }
}

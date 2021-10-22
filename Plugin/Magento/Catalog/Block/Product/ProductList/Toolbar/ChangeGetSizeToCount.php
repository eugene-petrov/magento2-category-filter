<?php

declare(strict_types=1);

namespace ReadyToGo\CategoryFilter\Plugin\Magento\Catalog\Block\Product\ProductList\Toolbar;

use Magento\Catalog\Block\Product\ProductList\Toolbar;

class ChangeGetSizeToCount
{
    /**
     * @param Toolbar $subject
     * @param callable $proceed
     * @return int
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGetTotalNum(Toolbar $subject, callable $proceed): int
    {
        return (int) $subject->getCollection()->count();
    }
}

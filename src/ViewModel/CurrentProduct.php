<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2022 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\ViewModel;

use Augustash\Backend\Registry\CurrentProduct as ProductRegistry;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * View model to retrieve the current product.
 */
class CurrentProduct implements ArgumentInterface
{
    /**
     * @var \Augustash\Backend\Registry\CurrentProduct
     */
    protected $productRegistry;

    /**
     * Class constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\Backend\Registry\CurrentProduct $productRegistry
     */
    public function __construct(
        ProductRegistry $productRegistry
    ) {
        $this->productRegistry = $productRegistry;
    }

    /**
     * Fetch current product from the registry.
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getCurrentProduct(): ProductInterface
    {
        return $this->productRegistry->getProduct();
    }
}

<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2022 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Registry;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Store\Model\Store;

/**
 * Currently viewed product model.
 * @api
 */
class CurrentProduct
{
    /**
     * @var \Magento\Catalog\Api\Data\ProductInterface
     */
    protected $product;

    /**
     * @var \Magento\Catalog\Api\Data\ProductInterfaceFactory
     */
    protected $productFactory;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Catalog\Api\Data\ProductInterfaceFactory $productFactory
     */
    public function __construct(
        ProductInterfaceFactory $productFactory
    ) {
        $this->productFactory = $productFactory;
    }

    /**
     * Set current product object.
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Augustash\Backend\Registry\CurrentProduct
     */
    public function setProduct(ProductInterface $product): CurrentProduct
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get current product object.
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product ?? $this->getNewProduct();
    }

    /**
     * Returns an empty product data object populated by store ID.
     *
     * @param int|null $storeId
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function getNewProduct(?int $storeId = null): ProductInterface
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->productFactory->create();

        if ($storeId) {
            $product->setStoreId($storeId);
        } else {
            $product->setStoreId(Store::DEFAULT_STORE_ID);
        }

        return $product;
    }
}

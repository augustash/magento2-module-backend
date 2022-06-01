<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2022 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Observer;

use Augustash\Backend\Registry\CurrentProduct;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Register the current product in a custom registry.
 * @see https://github.com/Vinai/module-current-product-example
 */
class RegisterCurrentProduct implements ObserverInterface
{
    /**
     * @var \Augustash\Backend\Registry\CurrentProduct
     */
    protected $productRegistry;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\Backend\Registry\CurrentProduct $productRegistry
     */
    public function __construct(
        CurrentProduct $productRegistry
    ) {
        $this->productRegistry = $productRegistry;
    }

    /**
     * Add current product to the registry.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(EventObserver $observer): void
    {
        $product = $observer->getEvent()->getData('product');
        $this->productRegistry->setProduct($product);
    }
}

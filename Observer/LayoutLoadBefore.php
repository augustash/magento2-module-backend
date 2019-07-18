<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\Backend\Observer;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Observer monitoring for `layout_load_before` events.
 */
class LayoutLoadBefore implements ObserverInterface
{
    /**
     * @var \Augustash\Backend\Api\ConfigInterface
     */
    protected $config;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\Backend\Api\ConfigInterface $config
     */
    public function __construct(
        ConfigInterface $config
    ) {
        $this->config = $config;
    }

    /**
     * Add custom layout handle that will remove blocks.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        if ($this->config->isDisableCompare()) {
            /** @var \Magento\Framework\View\LayoutInterface $layout */
            $layout = $observer->getData('layout');
            $layout
                ->getUpdate()
                ->addHandle('remove_product_compare');
        }

        if ($this->config->isDisableReview()) {
            /** @var \Magento\Framework\View\LayoutInterface $layout */
            $layout = $observer->getData('layout');
            $layout
                ->getUpdate()
                ->addHandle('remove_product_reviews');
        }
    }
}

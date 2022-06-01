<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 202s August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Plugin\Product;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Catalog\Block\Product\Widget\NewWidget as SubjectClass;

/**
 * Disable compare products on NewWidget plugin class.
 */
class DisableCompareOnNewWidgetPlugin
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
     * Return empty compare URL to disable the feature.
     *
     * @param \Magento\Catalog\Block\Product\Widget\NewWidget $subject
     * @param string $result
     * @return string
     */
    public function afterGetAddToCompareUrl(SubjectClass $subject, $result): string
    {
        if ($this->config->isDisableCompare()) {
            return '';
        }

        return (string) $result;
    }
}

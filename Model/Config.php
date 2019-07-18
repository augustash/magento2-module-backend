<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\Backend\Model;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Configuration class.
 */
class Config implements ConfigInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigValue($field, $scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $scope,
            $scopeCode
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getHiddenLinks($scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        $links = $this->scopeConfig->getValue(
            self::XML_PATH_HIDDEN_LINKS,
            ScopeInterface::SCOPE_STORE,
            $scope,
            $scopeCode
        );

        return explode(',', $links);
    }

    /**
     * {@inheritdoc}
     */
    public function isDisableCompare($scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_COMPARE_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $scope,
            $scopeCode
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isDisableReview($scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_REVIEW_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $scope,
            $scopeCode
        );
    }
}

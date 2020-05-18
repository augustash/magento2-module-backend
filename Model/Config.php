<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2020 August Ash (https://www.augustash.com)
 */

namespace Augustash\Backend\Model;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

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
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager

    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreManager(): StoreManagerInterface
    {
        return $this->storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigValue(
        $field,
        $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ) {
        if (in_array($scope, [ScopeInterface::SCOPE_STORE, ScopeInterface::SCOPE_STORES]) && is_null($scopeCode)) {
            $scopeCode = $this->getStoreManager()->getStore()->getCode();
        }

        if (in_array($scope, [ScopeInterface::SCOPE_WEBSITE, ScopeInterface::SCOPE_WEBSITES]) && is_null($scopeCode)) {
            $scopeCode = $this->getStoreManager()->getWebsite()->getCode();
        }

        return $this->scopeConfig->getValue($field, $scope, $scopeCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getHiddenLinks(
        $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): array {
        $links = $this->scopeConfig->getValue(
            self::XML_PATH_HIDDEN_LINKS,
            $scope,
            $scopeCode
        );

        return explode(',', $links);
    }

    /**
     * {@inheritdoc}
     */
    public function isDisableKeywords(
        $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): bool {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_KEYWORDS_ENABLED,
            $scope,
            $scopeCode
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isDisableCompare(
        $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): bool {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_COMPARE_ENABLED,
            $scope,
            $scopeCode
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isDisableReview(
        $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): bool {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_REVIEW_ENABLED,
            $scope,
            $scopeCode
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getGoogleSiteVerification(
        $scope =  ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): ?string {
        return $this->getConfigValue(self::XML_PATH_SITE_VERIFICATION_GOOGLE, $scope, $scopeCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getBingSiteVerification(
        $scope =  ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): ?string {
        return $this->getConfigValue(self::XML_PATH_SITE_VERIFICATION_BING, $scope, $scopeCode);
    }
}

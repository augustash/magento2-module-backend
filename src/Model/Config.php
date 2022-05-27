<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2022 August Ash, Inc. (https://www.augustash.com)
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
     * Returns a store manager object.
     *
     * @return \Magento\Store\Model\StoreManagerInterface
     */
    public function getStoreManager(): StoreManagerInterface
    {
        return $this->storeManager;
    }

    /**
     * Retrieves the module's config value for specified field.
     *
     * @param string $field
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return mixed
     */
    public function getConfigValue(
        string $field,
        string $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ) {
        if (\in_array($scope, [ScopeInterface::SCOPE_STORE, ScopeInterface::SCOPE_STORES]) && $scopeCode === null) {
            $scopeCode = $this->getStoreManager()->getStore()->getCode();
        }

        if (\in_array($scope, [ScopeInterface::SCOPE_WEBSITE, ScopeInterface::SCOPE_WEBSITES]) && $scopeCode === null) {
            $scopeCode = $this->getStoreManager()->getWebsite()->getCode();
        }

        return $this->scopeConfig->getValue($field, $scope, $scopeCode);
    }

    /**
     * Retrieves the list of links to hide.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return array
     */
    public function getHiddenLinks(
        string $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): array {
        $links = $this->scopeConfig->getValue(
            self::XML_PATH_HIDDEN_LINKS,
            $scope,
            $scopeCode
        );

        return \explode(',', $links);
    }

    /**
     * Retrieves the module's meta keywords enabled status.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return bool
     */
    public function isDisableKeywords(
        string $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): bool {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_KEYWORDS_ENABLED,
            $scope,
            $scopeCode
        );
    }

    /**
     * Retrieves the module's product compare enabled status.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return bool
     */
    public function isDisableCompare(
        string $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): bool {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_COMPARE_ENABLED,
            $scope,
            $scopeCode
        );
    }

    /**
     * Retrieves the module's product review enabled status.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return bool
     */
    public function isDisableReview(
        string $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): bool {
        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_REVIEW_ENABLED,
            $scope,
            $scopeCode
        );
    }

    /**
     * Retrieves the module's Google site verification code.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return null|string
     */
    public function getGoogleSiteVerification(
        string $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): ?string {
        return $this->getConfigValue(self::XML_PATH_SITE_VERIFICATION_GOOGLE, $scope, $scopeCode);
    }

    /**
     * Retrieves the module's Bing site verification code.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return null|string
     */
    public function getBingSiteVerification(
        string $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): ?string {
        return $this->getConfigValue(self::XML_PATH_SITE_VERIFICATION_BING, $scope, $scopeCode);
    }
}

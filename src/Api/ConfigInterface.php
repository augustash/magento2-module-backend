<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Api;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Service interface responsible for exposing configuration options.
 * @api
 */
interface ConfigInterface
{
    /**
     * Configuration constants.
     */
    const XML_PATH_HIDDEN_LINKS = 'ash/general/hidden_links';
    const XML_PATH_KEYWORDS_ENABLED = 'ash/general/disable_keywords_enabled';
    const XML_PATH_COMPARE_ENABLED = 'ash/general/disable_compare_enabled';
    const XML_PATH_REVIEW_ENABLED = 'ash/general/disable_review_enabled';
    const XML_PATH_SITE_VERIFICATION_GOOGLE = 'ash/site_verification/google';
    const XML_PATH_SITE_VERIFICATION_BING = 'ash/site_verification/bing';

    /**
     * Returns a store manager object.
     *
     * @return \Magento\Store\Model\StoreManagerInterface
     */
    public function getStoreManager(): StoreManagerInterface;

    /**
     * Retrieves the module's config value for specified field.
     *
     * @param string $field
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return mixed
     */
    public function getConfigValue(
        $field,
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    );

    /**
     * Retrieves the list of links to hide.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return array
     */
    public function getHiddenLinks(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ): array;

    /**
     * Retrieves the module's meta keywords enabled status.
     *
     * @param string $scope
     * @param int|string|\Magento\Store\Model\Store $scopeCode
     * @return bool
     */
    public function isDisableKeywords(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ): bool;

    /**
     * Retrieves the module's product compare enabled status.
     *
     * @param string $scope
     * @param int|string|\Magento\Store\Model\Store $scopeCode
     * @return bool
     */
    public function isDisableCompare(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ): bool;

    /**
     * Retrieves the module's product review enabled status.
     *
     * @param string $scope
     * @param int|string|\Magento\Store\Model\Store $scopeCode
     * @return bool
     */
    public function isDisableReview(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ): bool;

    /**
     * Retrieves the module's Google site verification code.
     *
     * @param string $scope
     * @param int|string|\Magento\Store\Model\Store $scopeCode
     * @return null|string
     */
    public function getGoogleSiteVerification(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ): ?string;

    /**
     * Retrieves the module's Bing site verification code.
     *
     * @param string $scope
     * @param int|string|\Magento\Store\Model\Store $scopeCode
     * @return null|string
     */
    public function getBingSiteVerification(
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ): ?string;
}

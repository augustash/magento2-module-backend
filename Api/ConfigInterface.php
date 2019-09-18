<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\Backend\Api;

use Magento\Framework\App\Config\ScopeConfigInterface;

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

    /**
     * Retrieves the module's config value for specified field.
     *
     * @param string $field
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return mixed
     */
    public function getConfigValue($field, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null);

    /**
     * Retrieves the list of links to hide.
     *
     * @param string $scope
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return array
     */
    public function getHiddenLinks($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null);

    /**
     * Retrieves the module's meta keywords enabled status.
     *
     * @param int|string|\Magento\Store\Model\Store $store
     * @return bool
     */
    public function isDisableKeywords($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null);

    /**
     * Retrieves the module's product compare enabled status.
     *
     * @param int|string|\Magento\Store\Model\Store $store
     * @return bool
     */
    public function isDisableCompare($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null);

    /**
     * Retrieves the module's product review enabled status.
     *
     * @param int|string|\Magento\Store\Model\Store $store
     * @return bool
     */
    public function isDisableReview($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null);
}

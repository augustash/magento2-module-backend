<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2023 August Ash, Inc. (https://www.augustash.com)
 */

declare(strict_types=1);

namespace Augustash\Backend\Api;

use Magento\Store\Model\ScopeInterface;

/**
 * Service interface responsible for exposing configuration options.
 *
 * @api
 */
interface ConfigInterface
{
    /**
     * Configuration constants.
     */
    public const XML_PATH_CUSTOMER_HIDDEN_LINKS = 'ash/general/hidden_account_links';
    public const XML_PATH_SITE_VERIFICATION_BING = 'ash/site_verification/bing';
    public const XML_PATH_SITE_VERIFICATION_GOOGLE = 'ash/site_verification/google';

    /**
     * Retrieves the store's Bing site verification code.
     *
     * @param string $scope
     * @param string|int|null $scopeCode
     * @return string|null
     */
    public function getBingSiteVerification(
        string $scope = ScopeInterface::SCOPE_STORES,
        string|int|null $scopeCode = null,
    ): ?string;

    /**
     * Retrieves the store's list of customer links to hide.
     *
     * @param string $scope
     * @param string|int|null $scopeCode
     * @return array
     */
    public function getCustomerLinksToHide(
        string $scope = ScopeInterface::SCOPE_STORES,
        string|int|null $scopeCode = null,
    ): array;

    /**
     * Retrieves the store's Google site verification code.
     *
     * @param string $scope
     * @param string|int|null $scopeCode
     * @return string|null
     */
    public function getGoogleSiteVerification(
        string $scope = ScopeInterface::SCOPE_STORES,
        string|int|null $scopeCode = null,
    ): ?string;
}

<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2023 August Ash, Inc. (https://www.augustash.com)
 */

declare(strict_types=1);

namespace Augustash\Backend\Model;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        protected ScopeConfigInterface $scopeConfig,
    ) {
    }

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
    ): ?string {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SITE_VERIFICATION_BING,
            $scope,
            $scopeCode
        );
    }

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
    ): array {
        $links = $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_HIDDEN_LINKS,
            $scope,
            $scopeCode
        );

        return \explode(',', $links);
    }

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
    ): ?string {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SITE_VERIFICATION_GOOGLE,
            $scope,
            $scopeCode
        );
    }
}

<?php

/**
 * August Ash Backend Module
 *
 * @author    Josh Johnson <jjohnson@augustash.com>
 * @copyright 2023 August Ash, Inc. (https://www.augustash.com)
 */

declare(strict_types=1);

namespace Augustash\Backend\ViewModel;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;

class SiteVerification implements ArgumentInterface
{
    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\Backend\Api\ConfigInterface $config
     */
    public function __construct(
        protected ConfigInterface $config,
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
        string|int|null $scopeCode = null
    ): ?string {
        return $this->config->getBingSiteVerification($scope, $scopeCode);
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
        string|int|null $scopeCode = null
    ): ?string {
        return $this->config->getGoogleSiteVerification($scope, $scopeCode);
    }
}

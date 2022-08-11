<?php

/**
 * August Ash Backend Module
 *
 * @author    Josh Johnson <jjohnson@augustash.com>
 * @copyright 2022 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\ViewModel;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * View model to inject site verification content.
 */
class SiteVerification implements ArgumentInterface
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
        $value = $this->config->getGoogleSiteVerification($scope, $scopeCode);
        return $value ? \trim($value) : null;
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
        $value = $this->config->getBingSiteVerification($scope, $scopeCode);
        return $value ? \trim($value) : null;
    }

    /**
     * Return the current store's store code.
     *
     * @return string
     */
    public function getStoreCode(): string
    {
        return $this->config->getStoreManager()->getStore()->getCode();
    }

    /**
     * Return the current store's website code.
     *
     * @return string
     */
    public function getWebsiteCode(): string
    {
        return $this->config->getStoreManager()->getWebsite()->getCode();
    }
}

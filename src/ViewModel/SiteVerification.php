<?php

/**
 * August Ash Backend Module
 *
 * @author    Josh Johnson <jjohnson@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\ViewModel;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

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
     * @param int|string|\Magento\Store\Model\Store $scopeCode
     * @return null|string
     */
    public function getGoogleSiteVerification(
        $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): ?string {
        return $this->config->getGoogleSiteVerification($scope, $scopeCode);
    }

    /**
     * Retrieves the module's Bing site verification code.
     *
     * @param string $scope
     * @param int|string|\Magento\Store\Model\Store $scopeCode
     * @return null|string
     */
    public function getBingSiteVerification(
        $scope = ScopeInterface::SCOPE_STORES,
        $scopeCode = null
    ): ?string {
        return $this->config->getBingSiteVerification($scope, $scopeCode);
    }

    /**
     * Return the current store's store code.
     *
     * @return string
     */
    public function getStoreCode()
    {
        return $this->config->getStoreManager()->getStore()->getCode();
    }

    /**
     * Return the current store's website code.
     *
     * @return string
     */
    public function getWebsiteCode()
    {
        return $this->config->getStoreManager()->getWebsite()->getCode();
    }
}

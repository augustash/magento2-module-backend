<?php

/**
 * August Ash Backend Module
 *
 * @author    Josh Johnson <josh@augustash.com>
 * @copyright Copyright (c) 2020 August Ash (https://www.augustash.com)
 */

namespace Augustash\Backend\ViewModel;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class SiteVerification implements ArgumentInterface
{
    /**
     * @var \Augustash\Backend\Api\ConfigInterface
     */
    protected $config;

    /**
     * Class constructor.
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
     * Return Google site verification code
     *
     * @return null|string
     */
    public function getGoogleSiteVerification($scope = ScopeInterface::SCOPE_STORES, $scopeCode = null): ?string
    {
        return $this->config->getGoogleSiteVerification($scope, $scopeCode);
    }

    /**
     * Return Bing site verification code
     *
     * @return null|string
     */
    public function getBingSiteVerification($scope = ScopeInterface::SCOPE_STORES, $scopeCode = null): ?string
    {
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
    public function getWebsitCode()
    {
        return $this->config->getStoreManager()->getWebsite()->getCode();
    }
}
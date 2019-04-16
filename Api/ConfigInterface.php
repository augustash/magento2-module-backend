<?php
/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2019 August Ash, Inc.
 */
namespace Augustash\Backend\Api;

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

    /**
     * Retrieves the module's config value for specified field.
     *
     * @param string $field
     * @param int|string|\Magento\Store\Model\Store $store
     * @return mixed
     */
    public function getConfigValue($field, $store = null);

    /**
     * Retrieves the list of links to hide.
     *
     * @param int|string|\Magento\Store\Model\Store $store
     * @return array
     */
    public function getHiddenLinks($store = null);
}

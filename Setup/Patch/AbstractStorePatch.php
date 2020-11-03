<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Setup\Patch;

use Augustash\Backend\Helper\Store as StoreHelper;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Abstract store data patch class.
 */
abstract class AbstractStorePatch implements DataPatchInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * @var \Augustash\Backend\Helper\Store
     */
    protected $storeHelper;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param \Augustash\Backend\Helper\Store $storeHelper
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        StoreHelper $storeHelper
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->storeHelper = $storeHelper;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}

<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Setup\Patch;

use Augustash\Backend\Helper\Cms as CmsHelper;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManager;

/**
 * Abstract CMS block/page data patch class.
 */
abstract class AbstractCmsPatch implements DataPatchInterface
{
    /**
     * @var \Augustash\Backend\Helper\Cms
     */
    protected $cmsHelper;

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param \Augustash\Backend\Helper\Cms $cmsHelper
     * @param \Magento\Store\Model\StoreManager $storeManager
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CmsHelper $cmsHelper,
        StoreManager $storeManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->cmsHelper = $cmsHelper;
        $this->storeManager = $storeManager;
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

<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2020 August Ash (https://www.augustash.com)
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
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    /**
     * @var \Augustash\Backend\Helper\Cms
     */
    protected $cmsHelper;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Store\Model\StoreManager $storeManager
     * @param \Augustash\Backend\Helper\Cms $cmsHelper
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        StoreManager $storeManager,
        CmsHelper $cmsHelper
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->storeManager = $storeManager;
        $this->cmsHelper = $cmsHelper;
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

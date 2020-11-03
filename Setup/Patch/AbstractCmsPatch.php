<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Setup\Patch;

use Augustash\Backend\Helper\Entity\CmsBlock as BlockHelper;
use Augustash\Backend\Helper\Entity\CmsPage as PageHelper;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManager;

/**
 * Abstract CMS block/page data patch class.
 */
abstract class AbstractCmsPatch implements DataPatchInterface
{
    /**
     * @var \Augustash\Backend\Helper\Entity\CmsBlock
     */
    protected $cmsBlockHelper;

    /**
     * @var \Augustash\Backend\Helper\Entity\CmsPage
     */
    protected $cmsPageHelper;

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
     * @param \Augustash\Backend\Helper\Entity\CmsBlock $blockHelper
     * @param \Augustash\Backend\Helper\Entity\CmsPage $pageHelper
     * @param \Magento\Store\Model\StoreManager $storeManager
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BlockHelper $blockHelper,
        PageHelper $pageHelper,
        StoreManager $storeManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->cmsBlockHelper = $blockHelper;
        $this->cmsPageHelper = $pageHelper;
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

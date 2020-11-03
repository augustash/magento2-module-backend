<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Helper\Entity;

use Augustash\Backend\Helper\AbstractBaseHelper;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\Group as GroupModel;
use Magento\Store\Model\GroupFactory;
use Magento\Store\Model\ResourceModel\Group as GroupResource;
use Magento\Store\Model\ResourceModel\Store as StoreResource;
use Magento\Store\Model\ResourceModel\Website as WebsiteResource;
use Magento\Store\Model\Store as StoreModel;
use Magento\Store\Model\StoreFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Website as WebsiteModel;
use Magento\Store\Model\WebsiteFactory;

/**
 * Store entity helper class.
 * @api
 */
class Store extends AbstractBaseHelper
{
    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager;

    /**
     * @var \Magento\Store\Model\GroupFactory
     */
    protected $groupFactory;

    /**
     * @var \Magento\Store\Model\ResourceModel\Group
     */
    protected $groupResource;

    /**
     * @var \Magento\Store\Model\StoreFactory
     */
    protected $storeFactory;

    /**
     * @var \Magento\Store\Model\ResourceModel\Store
     */
    protected $storeResource;

    /**
     * @var \Magento\Store\Model\WebsiteFactory
     */
    protected $websiteFactory;

    /**
     * @var \Magento\Store\Model\ResourceModel\Website
     */
    protected $websiteResource;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\GroupFactory $groupFactory
     * @param \Magento\Store\Model\ResourceModel\Group $groupResource
     * @param \Magento\Store\Model\StoreFactory $storeFactory
     * @param \Magento\Store\Model\ResourceModel\Store $storeResource
     * @param \Magento\Store\Model\WebsiteFactory $websiteFactory
     * @param \Magento\Store\Model\ResourceModel\Website $websiteResource
     */
    public function __construct(
        Context $context,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreManagerInterface $storeManager,
        ManagerInterface $eventManager,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository,
        GroupFactory $groupFactory,
        GroupResource $groupResource,
        WebsiteFactory $websiteFactory,
        WebsiteResource $websiteResource,
        StoreFactory $storeFactory,
        StoreResource $storeResource
    ) {
        parent::__construct($context, $filterBuilder, $searchCriteriaBuilder, $storeManager);
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
        $this->eventManager = $eventManager;
        $this->groupFactory = $groupFactory;
        $this->groupResource = $groupResource;
        $this->storeFactory = $storeFactory;
        $this->storeResource = $storeResource;
        $this->websiteFactory = $websiteFactory;
        $this->websiteResource = $websiteResource;
    }

    /**
     * Returns a store group object, fetched by code.
     *
     * @param string $code
     * @return \Magento\Store\Model\Group
     */
    public function getGroup($code): GroupModel
    {
        /** @var \Magento\Store\Model\Group $storeGroup */
        $storeGroup = $this->storeGroupFactory->create();
        $storeGroup->load($code, 'code');

        return $storeGroup;
    }

    /**
     * Returns a store object, fetched by code.
     *
     * @param string $code
     * @return \Magento\Store\Model\Store
     */
    public function getStore($code): StoreModel
    {
        /** @var \Magento\Store\Model\Store $store */
        $store = $this->storeFactory->create();
        $store->load($code, 'code');

        return $store;
    }

    /**
     * Returns a website object, fetched by code.
     *
     * @param string $code
     * @return \Magento\Store\Model\Website
     */
    public function getWebsite($code): WebsiteModel
    {
        /** @var \Magento\Store\Model\Website $website */
        $website = $this->websiteFactory->create();
        $website->load($code, 'code');

        return $website;
    }

    /**
     * Save a store group object.
     *
     * @param \Magento\Store\Model\Group $storeGroup
     * @return \Magento\Store\Model\Group
     */
    public function saveGroup(GroupModel $storeGroup): GroupModel
    {
        $this->groupResource->save($storeGroup);
        $this->eventManager->dispatch('store_group_save', [
            'group' => $storeGroup
        ]);

        return $storeGroup;
    }

    /**
     * Save a store object.
     *
     * @param \Magento\Store\Model\Store $store
     * @return \Magento\Store\Model\Store
     */
    public function saveStore(StoreModel $store): StoreModel
    {
        $this->storeResource->save($store);
        $this->storeManager->reinitStores();
        $this->eventManager->dispatch('store_edit', [
            'store' => $store
        ]);

        return $store;
    }

    /**
     * Save a website object.
     *
     * @param \Magento\Store\Model\Website $store
     * @return \Magento\Store\Model\Website
     */
    public function saveWebsite(WebsiteModel $website): WebsiteModel
    {
        $this->websiteResource->save($website);

        return $website;
    }

    /**
     * Create a new top-level root category.
     *
     * Generally for use with a new Magento website and store.
     *
     * @param string $name
     * @param string|null $urlKey
     * @return \Magento\Catalog\Model\Category
     */
    public function createRootCategory($name, $urlKey = null): Category
    {
        /** @var \Magento\Catalog\Model\Category $rootCategory */
        $rootCategory = $this->categoryFactory->create();
        $rootCategory->load(1);

        /** @var \Magento\Catalog\Model\Category $newRootCategory */
        $newRootCategory = $this->categoryFactory->create();
        $newRootCategory
            ->setName($name)
            ->setIsActive(true)
            ->setParentId($rootCategory->getId());
        if ($urlKey !== null) {
            $newRootCategory->setUrlKey($urlKey);
        }
        $this->categoryRepository->save($newRootCategory);

        return $newRootCategory;
    }

    /**
     * Automatically create the necessary website, store group, and store.
     *
     * @param string $code
     * @param string $name
     * @param int $sortOrder
     * @return void
     */
    public function createNewStore($code, $name, $sortOrder = 1)
    {
        $rootCategory = $this->createRootCategory(\sprintf('%s Root Category', $name));

        $website = $this->getWebsite($code);
        $website
            ->setName($name)
            ->setSortOrder($sortOrder);
        $website = $this->saveWebsite($website);

        $storeGroupCode = \sprintf('%s_store', $code);
        $storeGroup = $this->getGroup($storeGroupCode);
        $storeGroup
            ->setName(\sprintf('%s Store Group', $name))
            ->setRootCategoryId($rootCategory->getId())
            ->setWebsiteId($website->getId());
        $storeGroup = $this->saveGroup($storeGroup);

        $storeCode = \sprintf('%s_default', $code);
        $store = $this->getStore($storeCode);
        $store
            ->setName(\sprintf('%s Store View', $name))
            ->setStoreGroupId($storeGroup->getId())
            ->setWebsiteId($website->getId())
            ->setIsActive(1)
            ->setSortOrder($sortOrder);
        $store = $this->saveStore($store);
    }
}

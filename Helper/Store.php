<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Helper;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\Group as StoreGroupModel;
use Magento\Store\Model\GroupFactory as StoreGroupFactory;
use Magento\Store\Model\ResourceModel\Group as StoreGroupResource;
use Magento\Store\Model\ResourceModel\Store as StoreResource;
use Magento\Store\Model\ResourceModel\Website as WebsiteResource;
use Magento\Store\Model\Store as StoreModel;
use Magento\Store\Model\StoreFactory;
use Magento\Store\Model\StoreManager;
use Magento\Store\Model\Website as WebsiteModel;
use Magento\Store\Model\WebsiteFactory;

/**
 * Store helper class.
 */
class Store extends AbstractHelper
{
    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager;

    /**
     * @var \Magento\Store\Model\WebsiteFactory
     */
    protected $websiteFactory;

    /**
     * @var \Magento\Store\Model\ResourceModel\Website
     */
    protected $websiteResource;

    /**
     * @var \Magento\Store\Model\GroupFactory
     */
    protected $storeGroupFactory;

    /**
     * @var \Magento\Store\Model\ResourceModel\Group
     */
    protected $storeGroupResource;

    /**
     * @var \Magento\Store\Model\StoreFactory
     */
    protected $storeFactory;

    /**
     * @var \Magento\Store\Model\ResourceModel\Store
     */
    protected $storeResource;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManager $storeManager
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\WebsiteFactory $websiteFactory
     * @param \Magento\Store\Model\ResourceModel\Website $websiteResource
     * @param \Magento\Store\Model\GroupFactory $storeGroupFactory
     * @param \Magento\Store\Model\ResourceModel\Group $storeGroupResource
     * @param \Magento\Store\Model\StoreFactory $storeFactory
     * @param \Magento\Store\Model\ResourceModel\Store $storeResource
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        Context $context,
        StoreManager $storeManager,
        ManagerInterface $eventManager,
        WebsiteFactory $websiteFactory,
        WebsiteResource $websiteResource,
        StoreGroupFactory $storeGroupFactory,
        StoreGroupResource $storeGroupResource,
        StoreFactory $storeFactory,
        StoreResource $storeResource,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->storeManager = $storeManager;
        $this->eventManager = $eventManager;
        $this->websiteFactory = $websiteFactory;
        $this->websiteResource = $websiteResource;
        $this->storeGroupFactory = $storeGroupFactory;
        $this->storeGroupResource = $storeGroupResource;
        $this->storeFactory = $storeFactory;
        $this->storeResource = $storeResource;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context);
    }

    /**
     * Get store manager object.
     *
     * @return \Magento\Store\Model\StoreManager
     */
    public function getStoreManager(): StoreManager
    {
        return $this->storeManager;
    }

    /**
     * Fetch a new or existing website object by code.
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
     * Save a new or update an existing website object.
     *
     * @param string $code
     * @param array $data
     * @return \Magento\Store\Model\Website
     */
    public function saveWebsite($code, array $data): WebsiteModel
    {
        $website = $this->getWebsite($code);
        $website->setData($data);
        $this->websiteResource->save($website);

        return $website;
    }

    /**
     * Fetch a new or existing store group object by code.
     *
     * @param string $code
     * @return \Magento\Store\Model\Group
     */
    public function getStoreGroup($code): StoreGroupModel
    {
        /** @var \Magento\Store\Model\Group $storeGroup */
        $storeGroup = $this->storeGroupFactory->create();
        $storeGroup->load($code, 'code');

        return $storeGroup;
    }

    /**
     * Save a new or update an existing store group object.
     *
     * @param string $code
     * @param array $data
     * @return \Magento\Store\Model\Group
     */
    public function saveStoreGroup($code, array $data): StoreGroupModel
    {
        $storeGroup = $this->getStoreGroup($code);
        $storeGroup->setData($data);
        $this->storeGroupResource->save($storeGroup);
        $this->eventManager->dispatch('store_group_save', ['group' => $storeGroup]);

        return $storeGroup;
    }

    /**
     * Fetch a new or existing store object by code.
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
     * Save a new or update an existing store object.
     *
     * @param string $code
     * @param array $data
     * @return \Magento\Store\Model\Store
     */
    public function saveStore($code, array $data): StoreModel
    {
        $store = $this->getStore($code);
        $store->setData($data);
        $this->storeResource->save($store);
        $this->storeManager->reinitStores();
        $this->eventManager->dispatch('store_edit', ['store' => $store]);

        return $store;
    }

    /**
     * Automatically create the necessary website, store group, and store based
     * on defaults.
     *
     * @param string $code
     * @param string $name
     * @return void
     */
    public function createNewStore($code, $name)
    {
        $rootCategory = $this->createRootCategory(\sprintf('%s Categories', $name));

        $website = $this->saveWebsite($this->getWebsite($code), [
            'name' => $name,
            'sort_order' => 1,
        ]);

        $storeGroupCode = \sprintf('%s_store', $code);
        $storeGroup = $this->saveStoreGroup($this->getStoreGroup($storeGroupCode), [
            'name' => \sprintf('%s Store Group', $name),
            'root_category_id' => $rootCategory->getId(),
            'website_id' => $website->getId(),
        ]);

        $storeCode = \sprintf('%s_default', $code);
        $store = $this->saveStore($this->getStore($storeCode), [
            'is_active' => 1,
            'name' => \sprintf('%s Store View', $name),
            'sort_order' => 1,
            'store_group_id' => $storeGroup->getId(),
            'website_id' => $website->getId(),
        ]);
    }

    /**
     * Create a new top-level root category; generally for use with a new Magento
     * website.
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
}

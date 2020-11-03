<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Helper\Entity;

use Augustash\Backend\Helper\AbstractBaseHelper;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageInterfaceFactory;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * CMS page entity helper class.
 * @api
 */
class CmsPage extends AbstractBaseHelper
{
    /**
     * @var \Magento\Cms\Api\Data\PageInterfaceFactory
     */
    protected $pageFactory;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Cms\Api\Data\PageInterfaceFactory $pageFactory
     * @param \Magento\Cms\Api\PageRepositoryInterface $pageRepository
     */
    public function __construct(
        Context $context,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreManagerInterface $storeManager,
        PageInterfaceFactory $pageFactory,
        PageRepositoryInterface $pageRepository
    ) {
        parent::__construct($context, $filterBuilder, $searchCriteriaBuilder, $storeManager);
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
    }

    /**
     * Returns a CMS page object, fetched by identifier.
     *
     * Populates the page if one with a matching ID is found, otherwise
     * returns empty object.
     *
     * @param string $identifier
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\PageInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCmsPage($identifier, $storeId = null): PageInterface
    {
        try {
            $cmsPage = $this->pageRepository->getById($identifier);
        } catch (NoSuchEntityException $e) {
            $cmsPage = $this->getNewCmsPage($storeId);
        }

        return $cmsPage;
    }

    /**
     * Returns an empty CMS page object populated by store ID.
     *
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\PageInterface
     */
    public function getNewCmsPage($storeId = null): PageInterface
    {
        /** @var \Magento\Cms\Api\Data\PageInterface $cmsPage */
        $cmsPage = $this->pageFactory->create();

        if ($storeId) {
            $cmsPage->setStoreId($storeId);
        } else {
            $cmsPage->setStoreId($this->storeManager->getStore()->getId());
        }

        return $cmsPage;
    }

    /**
     * Returns an array of all CMS page objects.
     *
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\PageInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllCmsPages(
        $storeId = null
    ): array {
        /**
         * Returns an associative array of CMS pages with the key being the
         * page's ID.
         */
        $searchCriteria = $this->buildSearchCriteria([], 'store', $storeId);
        return $this->pageRepository
            ->getList($searchCriteria)
            ->getItems();
    }

    /**
     * Returns a CMS page object, fetched by attribute.
     *
     * Populates the page if one with matching parameters is found,
     * otherwise returns empty object.
     *
     * @param string $value
     * @param string $attributeCode
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\PageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCmsPageByAttribute(
        $value = null,
        $attributeCode = 'identifier',
        $storeId = null
    ): PageInterface {
        /**
         * Returns an associative array of pages with the key being the
         * page's ID.
         */
        $cmsPages = $this->getCmsPagesByAttribute(
            $value,
            $attributeCode,
            'eq',
            $storeId
        );

        if (!empty($cmsPages)) {
            $cmsPage = \array_shift($cmsPages);
        } else {
            $cmsPage = $this->getNewCmsPage();
        }

        return $cmsPage;
    }

    /**
     * Returns an array of CMS page objects, fetched by attribute.
     *
     * @param string $value
     * @param string $attributeCode
     * @param string $condition
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\PageInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCmsPagesByAttribute(
        $value = null,
        $attributeCode = 'identifier',
        $condition = 'like',
        $storeId = null
    ): array {
        $filters = [];
        $filters[] = $this->buildFilter($attributeCode, $value, $condition);
        $searchCriteria = $this->buildSearchCriteria($filters, 'store', $storeId);

        /**
         * Returns an associative array of CMS pages with the key being the
         * page's ID.
         */
        return $this->pageRepository
            ->getList($searchCriteria)
            ->getItems();
    }

    /**
     * Save a CMS page object.
     *
     * @param \Magento\Cms\Api\Data\PageInterface $cmsPage
     * @return \Magento\Cms\Api\Data\PageInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function saveCmsPage(PageInterface $cmsPage): PageInterface
    {
        return $this->pageRepository->save($cmsPage);
    }

    /**
     * Delete a CMS page object.
     *
     * @param \Magento\Cms\Api\Data\PageInterface $cmsPage
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteCmsPage(PageInterface $cmsPage): bool
    {
        return $this->pageRepository->delete($cmsPage);
    }
}

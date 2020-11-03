<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Helper\Entity;

use Augustash\Backend\Helper\AbstractBaseHelper;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\Data\BlockInterfaceFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * CMS block entity helper class.
 * @api
 */
class CmsBlock extends AbstractBaseHelper
{
    /**
     * @var \Magento\Cms\Api\Data\BlockInterfaceFactory
     */
    protected $blockFactory;

    /**
     * @var \Magento\Cms\Api\BlockRepositoryInterface
     */
    protected $blockRepository;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     */
    public function __construct(
        Context $context,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreManagerInterface $storeManager,
        BlockInterfaceFactory $blockFactory,
        BlockRepositoryInterface $blockRepository
    ) {
        parent::__construct($context, $filterBuilder, $searchCriteriaBuilder, $storeManager);
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
    }

    /**
     * Returns a CMS block object, fetched by identifier.
     *
     * Populates the block if one with a matching ID is found, otherwise
     * returns empty object.
     *
     * @param string $identifier
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\BlockInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCmsBlock($identifier, $storeId = null): BlockInterface
    {
        try {
            $cmsBlock = $this->blockRepository->getById($identifier);
        } catch (NoSuchEntityException $e) {
            $cmsBlock = $this->getNewCmsBlock($storeId);
        }

        return $cmsBlock;
    }

    /**
     * Returns an empty CMS block object populated by store ID.
     *
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\BlockInterface
     */
    public function getNewCmsBlock($storeId = null): BlockInterface
    {
        /** @var \Magento\Cms\Api\Data\BlockInterface $cmsBlock */
        $cmsBlock = $this->blockFactory->create();

        if ($storeId) {
            $cmsBlock->setStoreId($storeId);
        } else {
            $cmsBlock->setStoreId($this->storeManager->getStore()->getId());
        }

        return $cmsBlock;
    }

    /**
     * Returns an array of all CMS block objects.
     *
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\BlockInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllCmsBlocks(
        $storeId = null
    ): array {
        /**
         * Returns an associative array of CMS blocks with the key being the
         * block's ID.
         */
        $searchCriteria = $this->buildSearchCriteria([], 'store', $storeId);
        return $this->blockRepository
            ->getList($searchCriteria)
            ->getItems();
    }

    /**
     * Returns a CMS block object, fetched by attribute.
     *
     * Populates the block if one with matching parameters is found,
     * otherwise returns empty object.
     *
     * @param string $value
     * @param string $attributeCode
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\BlockInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCmsBlockByAttribute(
        $value = null,
        $attributeCode = 'identifier',
        $storeId = null
    ): array {
        /**
         * Returns an associative array of blocks with the key being the
         * block's ID.
         */
        return $this->getCmsBlocksByAttribute(
            $value,
            $attributeCode,
            'eq',
            $storeId
        );
    }

    /**
     * Returns an array of CMS block objects, fetched by attribute.
     *
     * @param string|null $value
     * @param string $attributeCode
     * @param string $condition
     * @param int|null $storeId
     * @return \Magento\Cms\Api\Data\BlockInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCmsBlocksByAttribute(
        $value = null,
        $attributeCode = 'identifier',
        $condition = 'like',
        $storeId = null
    ): array {
        $filters = [];
        if ($value !== null) {
            $filters[] = $this->buildFilter($attributeCode, $value, $condition);
        }
        $searchCriteria = $this->buildSearchCriteria($filters, 'store', $storeId);

        /**
         * Returns an associative array of CMS blocks with the key being the
         * block's ID.
         */
        return $this->blockRepository
            ->getList($searchCriteria)
            ->getItems();
    }

    /**
     * Save a CMS block object.
     *
     * @param \Magento\Cms\Api\Data\BlockInterface $cmsBlock
     * @return \Magento\Cms\Api\Data\BlockInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function saveCmsBlock(BlockInterface $cmsBlock): BlockInterface
    {
        return $this->blockRepository->save($cmsBlock);
    }

    /**
     * Delete a CMS block object.
     *
     * @param \Magento\Cms\Api\Data\BlockInterface $cmsBlock
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteCmsBlock(BlockInterface $cmsBlock): bool
    {
        return $this->blockRepository->delete($cmsBlock);
    }
}

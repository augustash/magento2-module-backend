<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2020 August Ash (https://www.augustash.com)
 */

namespace Augustash\Backend\Helper;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\Data\BlockInterfaceFactory;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageInterfaceFactory;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;

/**
 * CMS helper class.
 */
class Cms extends AbstractHelper
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
     * @var \Magento\Cms\Api\Data\PageInterfaceFactory
     */
    protected $pageFactory;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     * @param \Magento\Cms\Api\Data\PageInterfaceFactory $pageFactory
     * @param \Magento\Cms\Api\PageRepositoryInterface $pageRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     */
    public function __construct(
        Context $context,
        BlockInterfaceFactory $blockFactory,
        BlockRepositoryInterface $blockRepository,
        PageInterfaceFactory $pageFactory,
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder
    ) {
        parent::__construct($context);
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * Retrieve CMS block by identifier.
     *
     * @param string $identifier
     * @return \Magento\Cms\Api\Data\BlockInterface
     */
    public function getCmsBlockByIdentifier($identifier): BlockInterface
    {
        $matches[] = $this->filterBuilder
            ->setField($identifier)
            ->setConditionType('eq')
            ->setValue('identifier')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters($matches)
            ->setPageSize(1)
            ->create();

        /**
         * Returns an associative array of blocks with the key being the
         * block's ID.
         */
        $blocks = $this->blockRepository->getList($searchCriteria)->getItems();

        if (!empty($blocks)) {
            $cmsBlock = array_shift($blocks);
        } else {
            /** @var \Magento\Cms\Api\Data\BlockInterface $cmsBlock */
            $cmsBlock = $this->blockFactory->create();
        }

        return $cmsBlock;
    }

    /**
     * Retrieve CMS page by identifier.
     *
     * @param string $identifier
     * @return \Magento\Cms\Api\Data\PageInterface
     */
    public function getCmsPageByIdentifier($identifier): PageInterface
    {
        $matches[] = $this->filterBuilder
            ->setField($identifier)
            ->setConditionType('eq')
            ->setValue('identifier')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters($matches)
            ->setPageSize(1)
            ->create();

        /**
         * Returns an associative array of pages with the key being the
         * pages's ID.
         */
        $pages = $this->pageRepository->getList($searchCriteria)->getItems();

        if (!empty($pages)) {
            $cmsPage = array_shift($pages);
        } else {
            /** @var \Magento\Cms\Api\Data\PageInterface $cmsPage */
            $cmsPage = $this->pageFactory->create();
        }

        return $cmsPage;
    }

    /**
     * Save a CMS block.
     *
     * @param string $identifier
     * @param array $data CMS Block Data
     * @return \Magento\Cms\Api\Data\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveCmsBlock($identifier, $data = []): BlockInterface
    {
        $cmsBlock = $this->getCmsBlockByIdentifier($identifier);
        if (!$cmsBlock->getId()) {
            if (!isset($data['title'])) {
                throw new LocalizedException(__('A title is required to create a CMS block.'));
            }
            $cmsBlock
                ->setIdentifier($identifier)
                ->setTitle($data['title'])
                ->setContent($data['content'] ?? '')
                ->setIsActive($data['active'] ?? true)
                ->setData('stores', $data['stores'] ?? [0]);
        } else {
            if (isset($data['title'])) {
                $cmsBlock->setTitle($data['title']);
            }
            if (isset($data['content'])) {
                $cmsBlock->setContent($data['content']);
            }
            if (isset($data['active'])) {
                $cmsBlock->setIsActive($data['active']);
            }
            if (isset($data['stores'])) {
                $cmsBlock->setData('stores', $data['stores']);
            }
        }

        return $this->blockRepository->save($cmsBlock);
    }

    /**
     * Save a CMS page.
     *
     * @param string $identifier
     * @param array $data CMS page Data
     * @return \Magento\Cms\Api\Data\PageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveCmsPage($identifier, $data = []): PageInterface
    {
        $cmsPage = $this->getCmsPageByIdentifier($identifier);
        if (!$cmsPage->getId()) {
            if (!isset($data['title'])) {
                throw new LocalizedException(__('A title is required to create a CMS page.'));
            }
            $cmsPage
                ->setIdentifier($identifier)
                ->setTitle($data['title'])
                ->setContent($data['content'] ?? '')
                ->setContentHeading($data['contentHeading'] ?? '')
                ->setIsActive($data['active'] ?? true)
                ->setPageLayout($data['layout'] ?? '1column')
                ->setData('stores', $data['stores'] ?? [0]);
        } else {
            if (isset($data['title'])) {
                $cmsPage->setTitle($data['title']);
            }
            if (isset($data['content'])) {
                $cmsPage->setContent($data['content']);
            }
            if (isset($data['contentHeading'])) {
                $cmsPage->setContentHeading($data['contentHeading']);
            }
            if (isset($data['active'])) {
                $cmsPage->setIsActive($data['active']);
            }
            if (isset($data['layout'])) {
                $cmsPage->setPageLayout($data['layout']);
            }
            if (isset($data['stores'])) {
                $cmsPage->setData('stores', $data['stores']);
            }
        }

        return $this->pageRepository->save($cmsPage);
    }

    /**
     * Create a CMS block.
     *
     * @param string $identifier
     * @param string $title
     * @param string $content
     * @param bool $active
     * @param array $stores
     * @return \Magento\Cms\Api\Data\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createCmsBlock(
        $identifier,
        $title,
        $content,
        $active,
        $stores = [0]
    ): BlockInterface {
        return $this->saveCmsBlock($identifier, [
            'title' => $title,
            'content' => $content,
            'active' => $active,
            'stores' => $stores,
        ]);
    }

    /**
     * Create a CMS page.
     *
     * @param string $identifier
     * @param string $title
     * @param string $content
     * @param bool $active
     * @param string $contentHeading
     * @param string $layout
     * @param array $stores
     * @return \Magento\Cms\Api\Data\PageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createCmsPage(
        $identifier,
        $title,
        $content,
        $active,
        $contentHeading = '',
        $layout = '1column',
        $stores = [0]
    ): PageInterface {
        return $this->saveCmsPage($identifier, [
            'title' => $title,
            'content' => $content,
            'active' => $active,
            'contentHeading' => $contentHeading,
            'layout' => $layout,
            'stores' => $stores,
        ]);
    }

    /**
     * Updates a CMS block if it exists, otherwise creates a new block.
     *
     * @param string $identifier
     * @param array $data CMS Block Data
     * @return \Magento\Cms\Api\Data\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateCmsBlock($identifier, $data = []): BlockInterface
    {
        return $this->saveCmsBlock($identifier, $data);
    }

    /**
     * Updates a CMS page if it exists, otherwise creates a new page.
     *
     * @param string $identifier
     * @param array $data CMS page Data
     * @return \Magento\Cms\Api\Data\PageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateCmsPage($identifier, $data = []): PageInterface
    {
        return $this->saveCmsPage($identifier, $data);
    }
}

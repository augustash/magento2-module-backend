<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Helper;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Abstract base helper class.
 */
abstract class AbstractBaseHelper extends AbstractHelper
{
    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeManager = $storeManager;
    }

    /**
     * Get search criteria builder object.
     *
     * @return \Magento\Framework\Api\SearchCriteriaBuilder
     */
    public function getSearchCriteriaBuilder(): SearchCriteriaBuilder
    {
        return $this->searchCriteriaBuilder;
    }

    /**
     * Get filter builder object.
     *
     * @return \Magento\Framework\Api\FilterBuilder
     */
    public function getFilterBuilder(): FilterBuilder
    {
        return $this->filterBuilder;
    }

    /**
     * Build a search criteria object.
     *
     * A scope filter will be included if specified.
     *
     * @param \Magento\Framework\Api\Filter[] $filters
     * @param string $scopeType
     * @param null|string|\Magento\Store\Model\Store $scopeCode
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    public function buildSearchCriteria(
        array $filters,
        $scopeType = 'website',
        $scopeCode = null
    ): SearchCriteriaInterface {
        if ($scopeCode !== null) {
            $field = 'website_id';
            if ($scopeType == 'store') {
                $field = 'store_id';
            }
            $this->searchCriteriaBuilder->addFilter($field, $scopeCode, 'eq');
        }

        /**
         * Little hack to force the filters into an AND search instead of an OR.
         */
        foreach ($filters as $filter) {
            $this->searchCriteriaBuilder->addFilters([$filter]);
        }

        return $this->searchCriteriaBuilder->create();
    }

    /**
     * Build a search criteria filter object.
     *
     * @param string $field
     * @param mixed $value
     * @param string $condition
     * @return \Magento\Framework\Api\Filter
     */
    public function buildFilter($field, $value, $condition = 'eq'): Filter
    {
        return $this->filterBuilder
            ->setField($field)
            ->setConditionType($condition)
            ->setValue($value)
            ->create();
    }
}

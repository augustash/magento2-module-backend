<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Model\Config\Source\Account;

use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Customer account links source class.
 */
class Links implements OptionSourceInterface
{
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     */
    public function __construct(
        ProductMetadataInterface $productMetadata
    ) {
        $this->productMetadata = $productMetadata;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        $links = $this->getOpenSourceLinks();
        switch ($this->productMetadata->getEdition()) {
            case 'Enterprise':
                $links = \array_merge($links, $this->getEnterpriseLinks());
                break;
            case 'B2B':
                $links = \array_merge(
                    $links,
                    $this->getEnterpriseLinks(),
                    $this->getB2bLinks()
                );
                break;
        }
        return $links;
    }

    /**
     * Magento Open Source links getter.
     *
     * @return array
     */
    public function getOpenSourceLinks(): array
    {
        return [
            [
                'value' => "customer-account-navigation-account-edit-link",
                'label' => __('Account Information')
            ],
            [
                'value' => "customer-account-navigation-account-link",
                'label' => __('Account Dashboard')
            ],
            [
                'value' => "customer-account-navigation-address-link",
                'label' => __('Address Book')
            ],
            [
                'value' => "customer-account-navigation-billing-agreements-link",
                'label' => __('Billing Agreements')
            ],
            [
                'value' => "customer-account-navigation-downloadable-products-link",
                'label' => __('My Downloadable Products')
            ],
            [
                'value' => "customer-account-navigation-my-credit-cards-link",
                'label' => __('Stored Payment Methods')
            ],
            [
                'value' => "customer-account-navigation-newsletter-subscriptions-link",
                'label' => __('Newsletter Subscriptions')
            ],
            [
                'value' => "customer-account-navigation-orders-link",
                'label' => __('My Orders')
            ],
            [
                'value' => "customer-account-navigation-product-reviews-link",
                'label' => __('My Product Reviews')
            ],
            [
                'value' => "customer-account-navigation-wish-list-link",
                'label' => __('My Wish List')
            ],
        ];
    }

    /**
     * Magento Commerce links getter.
     *
     * @return array
     */
    public function getEnterpriseLinks(): array
    {
        return [
            [
                'value' => "customer-account-navigation-checkout-sku-link",
                'label' => __('Order by SKU')
            ],
            [
                'value' => "customer-account-navigation-customer-balance-link",
                'label' => __('Store Credit')
            ],
            [
                'value' => "customer-account-navigation-gift-card-link",
                'label' => __('Gift Card')
            ],
            [
                'value' => "customer-account-navigation-giftregistry-link",
                'label' => __('Gift Registry')
            ],
            [
                'value' => "customer-account-navigation-magento-invitation-link",
                'label' => __('My Invitations')
            ],
            [
                'value' => "customer-account-navigation-return-history-link",
                'label' => __('My Returns')
            ],
            [
                'value' => "customer-account-navigation-reward-link",
                'label' => __('Reward Points')
            ],
        ];
    }

    /**
     * Magento Commerce B2B links getter.
     *
     * @return array
     */
    public function getB2bLinks(): array
    {
        return [
            [
                'value' => "customer-account-navigation-company-credit-history-link",
                'label' => __('Company Credit')
            ],
            [
                'value' => "customer-account-navigation-company-link",
                'label' => __('Company Structure')
            ],
            [
                'value' => "customer-account-navigation-company-profile-link",
                'label' => __('Company Profile')
            ],
            [
                'value' => "customer-account-navigation-company-roles-link",
                'label' => __('Roles and Permissions')
            ],
            [
                'value' => "customer-account-navigation-company-users-link",
                'label' => __('Company Users')
            ],
            [
                'value' => "customer-account-navigation-quotes-link",
                'label' => __('My Quotes')
            ],
            [
                'value' => "customer-account-navigation-requisition-list-link",
                'label' => __('My Requisition Lists')
            ],
        ];
    }
}

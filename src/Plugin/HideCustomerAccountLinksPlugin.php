<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2023 August Ash, Inc. (https://www.augustash.com)
 */

declare(strict_types=1);

namespace Augustash\Backend\Plugin;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\View\Element\Html\Link\Current as SubjectClass;

class HideCustomerAccountLinksPlugin
{
    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\Backend\Api\ConfigInterface $config
     */
    public function __construct(
        protected ConfigInterface $config,
    ) {
    }

    /**
     * Remove customer account blocks that are supposed to be hidden.
     *
     * @param \Magento\Framework\View\Element\Html\Link\Current $subject
     * @param string|null $result
     * @return string
     */
    public function afterToHtml(SubjectClass $subject, ?string $result): string
    {
        $hiddenLinks = $this->config->getCustomerLinksToHide();
        if (\in_array($subject->getNameInLayout(), $hiddenLinks) || $result === null) {
            $result = '';
        }

        return (string) $result;
    }
}

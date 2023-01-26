<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2023 August Ash, Inc. (https://www.augustash.com)
 */

declare(strict_types=1);

namespace Augustash\Backend\Plugin;

use Magento\Framework\View\Page\Config as SubjectClass;

class RemoveMetaKeywordsPlugin
{
    /**
     * Return an empty string to disable rendering of keywords.
     *
     * @param \Magento\Framework\View\Page\Config $subject
     * @param string|null $result
     * @return string
     */
    public function afterGetKeywords(SubjectClass $subject, ?string $result): string
    {
        return '';
    }
}

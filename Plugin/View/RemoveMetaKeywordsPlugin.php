<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Plugin\View;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\View\Page\Config as SubjectClass;

/**
 * Removes keywords plugin class.
 */
class RemoveMetaKeywordsPlugin
{
    /**
     * @var \Augustash\Backend\Api\ConfigInterface
     */
    protected $config;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\Backend\Api\ConfigInterface $config
     */
    public function __construct(
        ConfigInterface $config
    ) {
        $this->config = $config;
    }

    /**
     * Return empty string to disable rendering of keywords.
     *
     * @param \Magento\Framework\View\Page\Config $subject
     * @param string $result
     * @return string
     */
    public function afterGetKeywords(SubjectClass $subject, $result): string
    {
        if ($this->config->isDisableKeywords() || $result === null) {
            return '';
        }

        return $result;
    }
}

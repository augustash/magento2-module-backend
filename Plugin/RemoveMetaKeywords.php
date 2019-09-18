<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\Backend\Plugin;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\View\Page\Config as Subject;

/**
 * Remove meta keywords plugin class.
 */
class RemoveMetaKeywords
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
    public function afterGetKeywords(Subject $subject, $result)
    {
        if ($this->config->isDisableKeywords()) {
            return '';
        }

        return $result;
    }
}

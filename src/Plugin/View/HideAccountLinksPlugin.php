<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2022 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Plugin\View;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\View\Element\Html\Link\Current as SubjectClass;

/**
 * Hide customer account links plugin class.
 */
class HideAccountLinksPlugin
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
     * Remove link blocks that are supposed to be hidden.
     *
     * @param \Magento\Framework\View\Element\Html\Link\Current $subject
     * @param string|null $result
     * @return string
     */
    public function afterToHtml(SubjectClass $subject, $result): string
    {
        $hiddenLinks = $this->config->getHiddenLinks();

        if (\in_array($subject->getNameInLayout(), $hiddenLinks) || $result === null) {
            $result = '';
        }

        return (string) $result;
    }
}

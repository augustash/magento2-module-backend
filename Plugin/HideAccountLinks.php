<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2019 August Ash (https://www.augustash.com)
 */

namespace Augustash\Backend\Plugin;

use Augustash\Backend\Api\ConfigInterface;
use Magento\Framework\View\Element\Html\Link\Current as CurrentLink;

/**
 * Hide customer account links plugin class.
 */
class HideAccountLinks
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
     * @param string $result
     * @return string
     */
    public function afterToHtml(CurrentLink $subject, $result)
    {
        $hiddenLinks = $this->config->getHiddenLinks();
        if (in_array($subject->getNameInLayout(), $hiddenLinks)) {
            $result = '';
        }
        return $result;
    }
}

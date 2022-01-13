<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2020 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\Backend\Command;

use Augustash\Backend\Api\Command\IsAdminAreaInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;

/**
 * @inheritdoc
 */
class IsAdminArea implements IsAdminAreaInterface
{
    /**
     * @var \Magento\Framework\App\State
     */
    protected $appState;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        State $appState
    ) {
        $this->appState = $appState;
    }

    /**
     * @inheritdoc
     */
    public function execute(): bool
    {
        return $this->appState->getAreaCode() === Area::AREA_ADMINHTML;
    }
}

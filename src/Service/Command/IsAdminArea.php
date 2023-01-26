<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2023 August Ash, Inc. (https://www.augustash.com)
 */

declare(strict_types=1);

namespace Augustash\Backend\Service\Command;

use Augustash\Backend\Api\Command\IsAdminAreaInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;

class IsAdminArea implements IsAdminAreaInterface
{
    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        protected State $appState,
    ) {
        $this->appState = $appState;
    }

    /**
     * Detect if action is in admin area.
     *
     * @return bool
     */
    public function execute(): bool
    {
        return $this->appState->getAreaCode() === Area::AREA_ADMINHTML;
    }
}

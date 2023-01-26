<?php

/**
 * August Ash Backend Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2023 August Ash, Inc. (https://www.augustash.com)
 */

declare(strict_types=1);

namespace Augustash\Backend\Api\Command;

/**
 * Service interface for admin area detection.
 *
 * @api
 */
interface IsAdminAreaInterface
{
    /**
     * Detect if action is in admin area.
     *
     * @return bool
     */
    public function execute(): bool;
}

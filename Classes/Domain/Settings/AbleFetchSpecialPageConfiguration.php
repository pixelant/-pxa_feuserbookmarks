<?php

namespace Pixelant\PxaFeuserbookmarks\Domain\Settings;


/**
 * @package Pixelant\PxaFeuserbookmarks\Domain\Settings
 */
trait AbleFetchSpecialPageConfiguration
{
    /**
     * Return special page configuration. Null if it doesn't exist
     *
     * @param int $page
     * @return array|null
     */
    protected function getSpecialPageConfiguration(int $page): ?array
    {
        return ($this->settings['specialPages'] ?? [])[$page] ?? null;
    }
}

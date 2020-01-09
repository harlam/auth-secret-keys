<?php

namespace harlam\Security\Auth\Interfaces;

use harlam\Security\Auth\Exceptions\KeyValidationException;

/**
 * Interface KeyValidatorInterface
 * @package harlam\Security\Auth\Interfaces
 */
interface KeyValidatorInterface
{
    /**
     * @param string $owner
     * @param string $key
     * @throws KeyValidationException
     */
    public function validate(string $owner, string $key): void;
}
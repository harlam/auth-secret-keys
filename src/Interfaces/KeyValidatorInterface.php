<?php

namespace harlam\Security\Auth\Interfaces;

use harlam\Security\Auth\Entity\SecretKey;

/**
 * Interface KeyValidatorInterface
 * @package harlam\Security\Auth\Interfaces
 */
interface KeyValidatorInterface
{
    /**
     * @param SecretKey $key
     * @param string $validationKey
     * @return bool
     */
    public function validate(SecretKey $key, string $validationKey): bool;
}
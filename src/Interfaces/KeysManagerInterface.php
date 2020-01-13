<?php

namespace harlam\Auth\Secrets\Interfaces;

use harlam\Auth\Secrets\Entity\KeyEntity;
use harlam\Auth\Secrets\Exception\StorageException;
use harlam\Auth\Secrets\Exception\Generation\KeyGenerationBaseException;
use harlam\Security\Auth\Exceptions\Validation\KeyValidationBaseException;

/**
 * @package harlam\Security\Auth\Interfaces
 */
interface KeysManagerInterface
{
    /**
     * @param string $owner
     * @return KeyEntity
     * @throws KeyGenerationBaseException
     * @throws StorageException
     */
    public function generate(string $owner): KeyEntity;

    /**
     * @param KeyEntity $key
     * @throws KeyValidationBaseException
     * @throws StorageException
     */
    public function validate(KeyEntity $key): void;
}
<?php

namespace harlam\Auth\Secrets\Interfaces;

use harlam\Auth\Secrets\Entity\KeyEntity;
use harlam\Auth\Secrets\Exception\Generation\KeyGenerationBaseException;
use harlam\Auth\Secrets\Exception\StorageException;
use harlam\Auth\Secrets\Exception\Validation\KeyValidationBaseException;

/**
 * @package harlam\Auth\Secrets\Interfaces
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
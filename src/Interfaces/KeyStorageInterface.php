<?php

namespace harlam\Security\Auth\Interfaces;

use harlam\Security\Auth\Entity\KeyEntityInterface;
use harlam\Security\Auth\Exceptions\StorageException;

/**
 * Interface KeyStorageInterface
 * @package harlam\Security\Auth\Interfaces
 */
interface KeyStorageInterface
{
    /**
     * @param KeyEntityInterface $entity
     * @return KeyEntityInterface
     * @throws StorageException
     */
    public function create(KeyEntityInterface $entity): KeyEntityInterface;

    /**
     * @param KeyEntityInterface $entity
     * @return KeyEntityInterface
     * @throws StorageException
     */
    public function update(KeyEntityInterface $entity): KeyEntityInterface;

    /**
     * @param string $owner
     * @return KeyEntityInterface|null
     */
    public function getLastKey(string $owner): ?KeyEntityInterface;
}
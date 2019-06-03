<?php

namespace harlam\Security\Auth\Interfaces;

use harlam\Security\Auth\Entity\SecretKey;

/**
 * Interface KeyStorageInterface
 * @package harlam\Security\Auth\Interfaces
 */
interface KeyStorageInterface
{
    /**
     * @param mixed $uid
     * @return SecretKey|null
     */
    public function find($uid): ?SecretKey;

    /**
     * @param SecretKey $code
     * @return SecretKey
     */
    public function create(SecretKey $code): SecretKey;

    /**
     * @param mixed $uid
     */
    public function delete($uid): void;

    /**
     * @param SecretKey $key
     */
    public function update(SecretKey $key): void;

    /**
     * @param string $owner
     * @return SecretKey|null
     */
    public function getLast(string $owner): ?SecretKey;
}
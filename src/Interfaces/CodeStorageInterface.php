<?php

namespace harlam\Security\Interfaces;

use harlam\Security\Entity\VerificationCode;

/**
 * Хранилище
 * Interface VerificationCodeStorageInterface
 * @package harlam\Security\Interfaces
 */
interface CodeStorageInterface
{
    public function find(string $owner, string $code): ?VerificationCode;

    public function create(VerificationCode $code): VerificationCode;

    public function delete(string $owner, string $code): bool;

    public function getLast(string $owner): ?VerificationCode;
}
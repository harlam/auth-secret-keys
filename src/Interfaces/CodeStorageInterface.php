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
    public function find(string $code, string $prefix = ''): ?VerificationCode;

    public function create(VerificationCode $code): VerificationCode;

    public function delete(string $code, string $prefix = ''): bool;

    public function getLast(string $prefix = ''): ?VerificationCode;
}
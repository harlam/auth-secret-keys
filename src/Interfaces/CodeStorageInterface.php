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
    public function find(string $uid): VerificationCode;

    public function create(VerificationCode $code): VerificationCode;

    public function delete(string $uid): bool;
}
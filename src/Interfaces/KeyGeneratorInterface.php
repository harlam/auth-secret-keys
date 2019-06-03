<?php

namespace harlam\Security\Auth\Interfaces;

use harlam\Security\Auth\Entity\SecretKey;

/**
 * Interface KeyGeneratorInterface
 * @package harlam\Security\Auth\Interfaces
 */
interface KeyGeneratorInterface
{
    /**
     * @return SecretKey
     */
    public function generate(): SecretKey;
}
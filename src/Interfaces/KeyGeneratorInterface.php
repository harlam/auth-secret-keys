<?php

namespace harlam\Security\Auth\Interfaces;

/**
 * Interface KeyGeneratorInterface
 * @package harlam\Security\Auth\Interfaces
 */
interface KeyGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string;
}
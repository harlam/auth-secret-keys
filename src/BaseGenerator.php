<?php

namespace harlam\Auth\Secrets;

use harlam\Auth\Secrets\Interfaces\StringGeneratorInterface;

/**
 * @package harlam\Auth\Secrets
 */
class BaseGenerator implements StringGeneratorInterface
{
    public function generate(): string
    {
        return (string)random_int(100000, 999999);
    }
}
<?php

namespace harlam\Auth\Secrets;

use harlam\Auth\Secrets\Interfaces\StringGeneratorInterface;

class BaseGenerator implements StringGeneratorInterface
{
    public function generate(): string
    {
        return (string)random_int(100000, 999999);
    }
}
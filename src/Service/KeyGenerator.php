<?php

namespace harlam\Security\Auth\Services;

use DateTime;
use Exception;
use harlam\Security\Auth\Entity\KeyEntity;
use harlam\Security\Auth\Entity\KeyEntityInterface;
use harlam\Security\Auth\Interfaces\KeyGeneratorInterface;

class KeyGenerator implements KeyGeneratorInterface
{
    /**
     * @return string
     * @throws Exception
     */
    public function generate(): string
    {
        return (string)random_int(100000, 999999);
    }
}
<?php

namespace harlam\Security\Auth\Services;

use DateTime;
use Exception;
use harlam\Security\Auth\Entity\SecretKey;
use harlam\Security\Auth\Interfaces\KeyGeneratorInterface;

class KeyGenerator implements KeyGeneratorInterface
{
    /**
     * @return SecretKey
     * @throws Exception
     */
    public function generate(): SecretKey
    {
        $key = (string)random_int(100000, 999999);

        return (new SecretKey())
            ->setKey($key)
            ->setAttempts(0)
            ->setCreatedAt(new DateTime());
    }
}
<?php

namespace harlam\Security;

use DateTime;
use harlam\Security\Entity\VerificationCode;
use harlam\Security\Interfaces\CodeGeneratorInterface;

class CodeSimpleGenerator implements CodeGeneratorInterface
{
    public function generate(): VerificationCode
    {
        $code = (string)random_int(100000, 999999);

        return (new VerificationCode())
            ->setCode($code)
            ->setCreatedAt(new DateTime());
    }
}
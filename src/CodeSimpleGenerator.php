<?php

namespace harlam\Security;

use DateTime;
use harlam\Security\Entity\VerificationCode;
use harlam\Security\Interfaces\CodeGeneratorInterface;

class CodeSimpleGenerator implements CodeGeneratorInterface
{
    protected $prefix = '';

    public function setPrefix(string $prefix): CodeGeneratorInterface
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function generate(): VerificationCode
    {
        $code = (string)random_int(100000, 999999);

        return (new VerificationCode())
            ->setPrefix($this->prefix)
            ->setCode($code)
            ->setCreatedAt(new DateTime());
    }
}
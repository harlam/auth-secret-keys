<?php

namespace harlam\Security\Interfaces;

use harlam\Security\Entity\VerificationCode;

interface CodeGeneratorInterface
{
    public function setPrefix(string $prefix): CodeGeneratorInterface;

    /**
     *
     * @return VerificationCode
     */
    public function generate(): VerificationCode;
}
<?php

namespace harlam\Security\Interfaces;

use harlam\Security\Entity\VerificationCode;

interface CodeGeneratorInterface
{
    /**
     * @param string $owner
     * @return CodeGeneratorInterface
     */
    public function setOwner(string $owner): CodeGeneratorInterface;

    /**
     * @return VerificationCode
     */
    public function generate(): VerificationCode;
}
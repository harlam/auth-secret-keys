<?php

namespace harlam\Security\Interfaces;

use harlam\Security\Entity\VerificationCode;

interface CodeGeneratorInterface
{
    /**
     *
     * @return VerificationCode
     */
    public function generate(): VerificationCode;
}
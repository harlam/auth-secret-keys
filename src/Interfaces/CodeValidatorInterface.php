<?php

namespace harlam\Security\Interfaces;

use harlam\Security\Entity\VerificationCode;

interface CodeValidatorInterface
{
    /**
     * @param VerificationCode $code
     * @return bool
     */
    public function validate(VerificationCode $code): bool;
}
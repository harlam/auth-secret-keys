<?php

namespace harlam\Security;

use harlam\Security\Entity\VerificationCode;
use harlam\Security\Interfaces\CodeValidatorInterface;

class CodeValidator implements CodeValidatorInterface
{
    protected $maxAttempts;
    protected $maxLifetime;

    public function __construct(int $maxAttempts, int $maxLifetime)
    {
        $this->maxAttempts = $maxAttempts;
        $this->maxLifetime = $maxLifetime;
    }

    public function validate(VerificationCode $code): bool
    {
        return false;
    }
}
<?php

namespace harlam\Security;

use RuntimeException;
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
        $lifetime = time() - $code->getCreatedAt()->getTimestamp();

        if ($lifetime >= $this->maxLifetime) {
            throw new RuntimeException("Время истекло");
        }

        if ($code->getAttempts() >= $this->maxAttempts) {
            throw new RuntimeException("Превышено число попыток ввода");
        }

        return true;
    }
}
<?php

namespace harlam\Security\Auth\Services;

use harlam\Security\Auth\Entity\SecretKey;
use harlam\Security\Auth\Exceptions\KeyValidationException;
use harlam\Security\Auth\Exceptions\ValidationLifetimeException;
use harlam\Security\Auth\Exceptions\ValidationMaxAttemptsException;
use harlam\Security\Auth\Interfaces\KeyValidatorInterface;

class KeyValidator implements KeyValidatorInterface
{
    protected $maxAttempts = 3;
    protected $maxLifetime = 300;

    /**
     * @param int $maxAttempts
     * @return KeyValidator
     */
    public function setMaxAttempts(int $maxAttempts): KeyValidator
    {
        $this->maxAttempts = $maxAttempts;
        return $this;
    }

    /**
     * @param int $maxLifetime
     * @return KeyValidator
     */
    public function setMaxLifetime(int $maxLifetime): KeyValidator
    {
        $this->maxLifetime = $maxLifetime;
        return $this;
    }

    /**
     * @param SecretKey $key
     * @param string $validationKey
     * @return bool
     */
    public function validate(SecretKey $key, string $validationKey): bool
    {
        $lifetime = time() - $key->getCreatedAt()->getTimestamp();

        if ($lifetime >= $this->maxLifetime) {
            throw new ValidationLifetimeException();
        }

        if ($key->getAttempts() >= $this->maxAttempts) {
            throw new ValidationMaxAttemptsException();
        }

        if ($key->getKey() !== $validationKey) {
            throw new KeyValidationException();
        }

        return true;
    }
}
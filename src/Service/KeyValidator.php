<?php

namespace harlam\Security\Auth\Services;

use harlam\Security\Auth\Entity\KeyEntity;
use harlam\Security\Auth\Exceptions\KeyValidationException;
use harlam\Security\Auth\Exceptions\ValidationLifetimeException;
use harlam\Security\Auth\Exceptions\KeyAttemptsLimitException;
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
     * @param string $owner
     * @param string $key
     * @throws KeyAttemptsLimitException
     * @throws KeyValidationException
     */
    public function validate(string $owner, string $key): void
    {
        $storedKey =
        $lifetime = time() - $key->getCreatedAt()->getTimestamp();

        if ($lifetime >= $this->maxLifetime) {
            throw new ValidationLifetimeException();
        }

        if ($key->getAttempts() >= $this->maxAttempts) {
            throw new KeyAttemptsLimitException();
        }

        if ($key->getKey() !== $validationKey) {
            throw new KeyValidationException();
        }

        return true;
    }
}
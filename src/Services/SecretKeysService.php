<?php

namespace harlam\Security\Auth\Services;

use harlam\Security\Auth\Entity\SecretKey;
use harlam\Security\Auth\Exceptions\KeyValidationException;
use harlam\Security\Auth\Exceptions\TooManyRequests;
use harlam\Security\Auth\Interfaces\KeyGeneratorInterface;
use harlam\Security\Auth\Interfaces\KeyStorageInterface;
use harlam\Security\Auth\Interfaces\KeyValidatorInterface;

/**
 * Class SecretKeysService
 * @package harlam\Security\Auth\Services
 */
class SecretKeysService
{
    protected $generator;
    protected $validator;
    protected $storage;
    protected $requestTimeInterval;

    public function __construct(KeyGeneratorInterface $generator, KeyValidatorInterface $validator, KeyStorageInterface $storage)
    {
        $this->generator = $generator;
        $this->validator = $validator;
        $this->storage = $storage;
    }

    /**
     * @param int $time
     * @return SecretKeysService
     */
    public function setRequestInterval(int $time): SecretKeysService
    {
        $this->requestTimeInterval = $time;
        return $this;
    }

    /**
     * @param string $owner
     * @return SecretKey
     */
    public function create(string $owner): SecretKey
    {
        $this->beforeCreate($owner);

        $key = $this->generator->generate();
        $key->setOwner($owner);

        return $this->storage->create($key);
    }

    /**
     * @param string $owner
     */
    protected function beforeCreate(string $owner): void
    {
        $key = $this->storage->getLast($owner);

        if ($key !== null && $this->requestTimeInterval !== null) {
            $lifetime = time() - $key->getCreatedAt()->getTimestamp();

            if ($lifetime < $this->requestTimeInterval) {
                throw new TooManyRequests();
            }
        }
    }

    /**
     * @param string $owner
     * @param string $validationKey
     * @return bool
     */
    public function validate(string $owner, string $validationKey): bool
    {
        $key = $this->storage->getLast($owner);

        if ($key === null) {
            return false;
        }

        try {
            if ($this->validator->validate($key, $validationKey) === false) {
                throw new KeyValidationException();
            }
        } catch (KeyValidationException $exception) {
            $key->setAttempts($key->getAttempts() + 1);
            $this->storage->update($key);
            throw $exception;
        }

        return true;
    }
}
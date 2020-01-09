<?php

namespace harlam\Security\Auth\Services;

use harlam\Security\Auth\Entity\KeyEntity;
use harlam\Security\Auth\Entity\KeyEntityInterface;
use harlam\Security\Auth\Exceptions\KeyValidationException;
use harlam\Security\Auth\Exceptions\TooManyRequests;
use harlam\Security\Auth\Interfaces\KeyGeneratorInterface;
use harlam\Security\Auth\Interfaces\KeyStorageInterface;
use harlam\Security\Auth\Interfaces\KeyValidatorInterface;

/**
 * Class SecretKeysService
 * @package harlam\Security\Auth\Service
 */
class SecretKeysService
{
    protected $generator;
    protected $validator;
    protected $storage;
    protected $requestTimeInterval = 60;

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
     * @return KeyEntityInterface
     */
    public function create(string $owner): KeyEntityInterface
    {
        $this->checkRequestInterval($owner);

        $key = new KeyEntity($owner, $this->generator->generate());

        return $this->storage->create($key);
    }

    /**
     * @param string $owner
     * @param string $validationKey
     * @throws KeyValidationException
     */
    public function validate(string $owner, string $validationKey): void
    {
        $key = $this->storage->getLastKey($owner);

        if ($key === null) {
            throw new KeyValidationException();
        }

        try {
            $this->validator->validate($key, $validationKey);
        } catch (KeyValidationException $exception) {
            $this->storage->update($key->incAttempts());
            throw $exception;
        }

        return true;
    }

    /**
     * @param string $owner
     * @throws TooManyRequests
     */
    protected function checkRequestInterval(string $owner): void
    {
        $key = $this->storage->getLastKey($owner);

        if ($key !== null && $this->requestTimeInterval !== null) {
            $lifetime = time() - $key->getCreatedAt()->getTimestamp();

            if ($lifetime < $this->requestTimeInterval) {
                throw new TooManyRequests();
            }
        }
    }
}
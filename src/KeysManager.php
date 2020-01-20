<?php

namespace harlam\Auth\Secrets;

use harlam\Auth\Secrets\Entity\KeyEntity;
use harlam\Auth\Secrets\Exception\Generation\TooManyRequests;
use harlam\Auth\Secrets\Exception\Validation\BadKeyException;
use harlam\Auth\Secrets\Exception\Validation\FindKeyException;
use harlam\Auth\Secrets\Exception\Validation\IncorrectKeyException;
use harlam\Auth\Secrets\Exception\Validation\KeyAttemptsLimitException;
use harlam\Auth\Secrets\Exception\Validation\KeyExpiredException;
use harlam\Auth\Secrets\Exception\Validation\KeyValidationBaseException;
use harlam\Auth\Secrets\Interfaces\KeysManagerInterface;
use harlam\Auth\Secrets\Interfaces\StorageInterface;
use harlam\Auth\Secrets\Interfaces\StringGeneratorInterface;

/**
 * @package harlam\Auth\Secrets
 */
class KeysManager implements KeysManagerInterface
{
    private $storage;
    private $stringGenerator;

    protected $maxAttempts = 3;
    protected $maxLifetime = 300;
    protected $requestTimeInterval = 60;
    protected $presetKeys = [];

    public function __construct(StorageInterface $storage, StringGeneratorInterface $stringGenerator)
    {
        $this->storage = $storage;
        $this->stringGenerator = $stringGenerator;
    }

    /**
     * @param int $maxAttempts max validation attempts
     * @return KeysManager
     */
    public function setValidationMaxAttempts(int $maxAttempts): KeysManager
    {
        $this->maxAttempts = $maxAttempts;
        return $this;
    }

    /**
     * @param int $maxLifetime key max lifetime
     * @return KeysManager
     */
    public function setValidationMaxLifetime(int $maxLifetime): KeysManager
    {
        $this->maxLifetime = $maxLifetime;
        return $this;
    }

    /**
     * @param int $time key request interval in seconds
     * @return KeysManager
     */
    public function setRequestInterval(int $time): KeysManager
    {
        $this->requestTimeInterval = $time;
        return $this;
    }

    /**
     * @param array $keys static keys list (['owner' => 'secret'])
     * @return KeysManager
     */
    public function setPresetKeys(array $keys): KeysManager
    {
        $this->presetKeys = $keys;
        return $this;
    }

    /**
     * @param string $owner
     * @return KeyEntity
     */
    public function generate(string $owner): KeyEntity
    {
        $this->checkRequestInterval($owner);

        $key = key_exists($owner, $this->presetKeys) ? (string)$this->presetKeys[$owner] : $this->stringGenerator->generate();

        $entity = (new KeyEntity)
            ->setOwner($owner)
            ->setKey($key);

        return $this->storage->create($entity);
    }

    /**
     * @param KeyEntity $key
     * @throws KeyValidationBaseException
     */
    public function validate(KeyEntity $key): void
    {
        if ($key->getOwner() === null) {
            throw new BadKeyException('Owner is required');
        }

        $storedKey = $this->storage->getLastKey($key->getOwner());

        if ($storedKey === null) {
            throw new FindKeyException();
        } elseif (($key->getCreatedAt()->getTimestamp() - $storedKey->getCreatedAt()->getTimestamp()) > $this->maxLifetime) {
            throw new KeyExpiredException();
        } elseif ($storedKey->getAttempts() >= $this->maxAttempts) {
            throw new KeyAttemptsLimitException();
        } elseif ($key->getKey() !== $storedKey->getKey()) {
            $this->storage->update($storedKey->incAttempts());
            throw new IncorrectKeyException();
        }
    }

    /**
     * @param string $owner
     * @throws TooManyRequests
     */
    protected function checkRequestInterval(string $owner): void
    {
        $key = $this->storage->getLastKey($owner);

        if ($key !== null) {
            $lifetime = time() - $key->getCreatedAt()->getTimestamp();

            if ($lifetime < $this->requestTimeInterval) {
                throw new TooManyRequests();
            }
        }
    }
}
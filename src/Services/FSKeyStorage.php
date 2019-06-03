<?php

namespace harlam\Security\Auth\Services;

use DateTime;
use harlam\Security\Auth\Entity\SecretKey;
use harlam\Security\Auth\Exceptions\KeyStorageException;
use harlam\Security\Auth\Interfaces\KeyStorageInterface;
use RuntimeException;

class FSKeyStorage implements KeyStorageInterface
{
    protected $path;

    public function __construct(string $path)
    {
        if (!is_dir($path) && !mkdir($path)) {
            throw new RuntimeException("Storage initialization error in '{$this->path}'");
        }

        $this->path = $path;
    }

    /**
     * @param mixed $uid
     * @return SecretKey|null
     */
    public function find($uid): ?SecretKey
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @param SecretKey $key
     * @return SecretKey
     */
    public function create(SecretKey $key): SecretKey
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $key->getOwner();

        $saved = file_put_contents($file, json_encode([
            'owner' => $key->getOwner(),
            'key' => $key->getKey(),
            'attempts' => $key->getAttempts(),
            'created' => $key->getCreatedAt()->format('Y-m-d H:i:s'),
        ]));

        if (!$saved) {
            throw new KeyStorageException();
        }

        return $key;
    }

    /**
     * @param mixed $uid
     */
    public function delete($uid): void
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * @param SecretKey $key
     */
    public function update(SecretKey $key): void
    {
        $this->create($key);
    }

    /**
     * @param string $owner
     * @return SecretKey|null
     */
    public function getLast(string $owner): ?SecretKey
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $owner;

        if (!file_exists($file)) {
            return null;
        }

        $data = file_get_contents($file);

        if ($data === false || ($json = json_decode($data)) === false) {
            throw new KeyStorageException();
        }

        return (new SecretKey())
            ->setOwner($json->owner)
            ->setKey($json->key)
            ->setAttempts($json->attempts)
            ->setCreatedAt(DateTime::createFromFormat('Y-m-d H:i:s', $json->created));
    }
}
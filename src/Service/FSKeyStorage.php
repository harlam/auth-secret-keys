<?php

namespace harlam\Security\Auth\Services;

use DateTime;
use harlam\Security\Auth\Entity\KeyEntityInterface;
use harlam\Security\Auth\Entity\KeyEntity;
use harlam\Security\Auth\Exceptions\StorageException;
use harlam\Security\Auth\Interfaces\KeyStorageInterface;

class FSKeyStorage implements KeyStorageInterface
{
    protected $path;

    public function __construct(string $path)
    {
        if (!is_dir($path) && !mkdir($path)) {
            throw new StorageException("Can't initialize in '{$this->path}'");
        }

        $this->path = $path;
    }

    /**
     * @param KeyEntityInterface $entity
     * @return KeyEntityInterface
     * @throws StorageException
     */
    public function create(KeyEntityInterface $entity): KeyEntityInterface
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $entity->getOwner();

        $isSaved = file_put_contents($file, json_encode([
            'owner' => $entity->getOwner(),
            'key' => $entity->getKey(),
            'attempts' => $entity->getAttempts(),
            'created' => $entity->getCreatedAt()->format('Y-m-d H:i:s'),
        ]));

        if (false === $isSaved) {
            throw new StorageException();
        }

        return $entity;
    }

    /**
     * @param string $owner
     * @return KeyEntityInterface|null
     * @throws StorageException
     */
    public function getLastKey(string $owner): ?KeyEntityInterface
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $owner;

        if (!file_exists($file)) {
            return null;
        }

        $data = file_get_contents($file);

        if ($data === false || ($json = json_decode($data)) === false) {
            throw new StorageException();
        }

        $createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $json->created);
        return new KeyEntity($json->owner, $json->key, $json->attempts, $createdAt);
    }
}
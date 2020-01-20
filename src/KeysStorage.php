<?php

namespace harlam\Auth\Secrets;

use DateTime;
use harlam\Auth\Secrets\Entity\KeyEntity;
use harlam\Auth\Secrets\Exception\StorageException;
use harlam\Auth\Secrets\Interfaces\StorageInterface;

/**
 * @package harlam\Auth\Secrets
 */
class KeysStorage implements StorageInterface
{
    private $path;

    public function __construct(string $path)
    {
        if ((!is_dir($path) && !mkdir($path, 0700, true)) || !is_string(($p = realpath($path)))) {
            throw new StorageException("Storage initialization error in '{$this->path}'");
        }

        $this->path = $p . DIRECTORY_SEPARATOR;
    }

    /**
     * @param KeyEntity $entity
     * @return KeyEntity
     * @throws StorageException
     */
    public function create(KeyEntity $entity): KeyEntity
    {
        if ($entity->getOwner() === null || $entity->getKey() === null) {
            throw new StorageException('Owner and Key is required');
        }

        $file = $this->path . $entity->getOwner();

        $saved = file_put_contents($file, json_encode([
            'key' => $entity->getKey(),
            'attempts' => $entity->getAttempts(),
            'created' => $entity->getCreatedAt()->format('Y-m-d H:i:s'),
        ]));

        if (!$saved) {
            throw new StorageException("Can't save key for owner '{$entity->getOwner()}'");
        }

        return $entity;
    }

    /**
     * @param KeyEntity $entity
     * @return KeyEntity
     * @throws StorageException
     */
    public function update(KeyEntity $entity): KeyEntity
    {
        return $this->create($entity);
    }

    /**
     * @param string $owner
     * @return KeyEntity|null
     * @throws StorageException
     */
    public function getLastKey(string $owner): ?KeyEntity
    {
        $file = $this->path . $owner;

        if (!file_exists($file)) {
            return null;
        }

        $data = file_get_contents($file);

        if ($data === false || ($json = json_decode($data)) === false) {
            throw new StorageException();
        }

        return (new KeyEntity)
            ->setOwner($owner)
            ->setKey($json->key)
            ->setAttempts((int)$json->attempts)
            ->setCreatedAt(DateTime::createFromFormat('Y-m-d H:i:s', $json->created));
    }
}
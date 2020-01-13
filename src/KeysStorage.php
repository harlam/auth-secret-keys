<?php

namespace harlam\Auth\Secrets;

use DateTime;
use harlam\Auth\Secrets\Entity\KeyEntity;
use harlam\Auth\Secrets\Exception\StorageException;
use harlam\Auth\Secrets\Interfaces\StorageInterface;
use PDO;
use Ramsey\Uuid\Uuid;


class KeysStorage implements StorageInterface
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param KeyEntity $entity
     * @return KeyEntity
     * @throws StorageException
     */
    public function create(KeyEntity $entity): KeyEntity
    {
        $entity->setUid(Uuid::uuid4()->toString());

        if ($entity->getCreatedAt() === null) {
            $entity->setCreatedAt(new DateTime());
        }

        $query = 'INSERT INTO secret_keys(uid, owner, key, attempts, created_at) VALUES (:uid, :owner, :key, :attempts, :created)';
        $statement = $this->connection->prepare($query);

        $isSaved = $statement->execute([
            'uid' => $entity->getUid(),
            'owner' => $entity->getOwner(),
            'key' => $entity->getKey(),
            'attempts' => $entity->getAttempts(),
            'created' => $entity->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);

        if (false === $isSaved) {
            throw new StorageException();
        }

        return $entity->setUid($uid)
            ->setCreatedAt($created);
    }

    /**
     * @param $uid
     * @return KeyEntity|null
     */
    public function find($uid): ?KeyEntity
    {
        // TODO: Implement find() method.
    }

    /**
     * @param KeyEntity $entity
     * @return KeyEntity
     * @throws StorageException
     */
    public function update(KeyEntity $entity): KeyEntity
    {
        // TODO: Implement update() method.
    }

    /**
     * @param string $owner
     * @return KeyEntity|null
     * @throws StorageException
     */
    public function getLastKey(string $owner): ?KeyEntity
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
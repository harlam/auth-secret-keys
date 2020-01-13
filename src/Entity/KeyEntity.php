<?php

namespace harlam\Auth\Secrets\Entity;

use DateTime;

/**
 * Secret key entity
 */
class KeyEntity
{
    private $uid;
    /** @var string Owner */
    private $owner;
    /** @var string Code */
    private $key;
    /** @var int Attempts */
    private $attempts = 0;
    /** @var DateTime Date/Time */
    private $createdAt;

    /**
     * @param $uid
     * @return KeyEntity
     */
    public function setUid($uid): KeyEntity
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @param string $owner
     * @return KeyEntity
     */
    public function setOwner(string $owner): KeyEntity
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @param string $key
     * @return KeyEntity
     */
    public function setKey(string $key): KeyEntity
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param int $count
     * @return KeyEntity
     */
    public function incAttempts(int $count = 1): KeyEntity
    {
        $this->attempts += $count;
        return $this;
    }

    /**
     * @param DateTime $createdAt
     * @return KeyEntity
     */
    public function setCreatedAt(DateTime $createdAt): KeyEntity
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return null|string
     */
    public function getOwner(): ?string
    {
        return $this->owner;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }
}
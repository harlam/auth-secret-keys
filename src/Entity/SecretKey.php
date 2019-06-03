<?php

namespace harlam\Security\Auth\Entity;

use DateTime;

/**
 * Secret key entity
 */
class SecretKey
{
    /** @var mixed UID */
    protected $uid;
    /** @var string Owner */
    protected $owner = '';
    /** @var string Code */
    protected $key;
    /** @var integer Attempts */
    protected $attempts = 0;
    /** @var DateTime Date/Time */
    protected $createdAt;

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid): SecretKey
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     * @return SecretKey
     */
    public function setOwner(string $owner): SecretKey
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return SecretKey
     */
    public function setKey($key): SecretKey
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     * @return SecretKey
     */
    public function setAttempts(int $attempts): SecretKey
    {
        $this->attempts = $attempts;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return SecretKey
     */
    public function setCreatedAt(DateTime $createdAt): SecretKey
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
<?php

namespace harlam\Security\Auth\Entity;

use DateTime;

/**
 * Secret key entity
 */
class KeyEntity implements KeyEntityInterface
{
    /** @var string Owner */
    private $owner;
    /** @var string Code */
    private $key;
    /** @var int Attempts */
    private $attempts;
    /** @var DateTime Date/Time */
    private $createdAt;

    public function __construct(string $owner, string $key, int $attempts = 0, DateTime $createdAt = null)
    {
        $this->owner = $owner;
        $this->key = $key;
        $this->attempts = $attempts;
        $this->createdAt = $createdAt === null ? new DateTime() : $createdAt;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @return string
     */
    public function getKey(): string
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
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
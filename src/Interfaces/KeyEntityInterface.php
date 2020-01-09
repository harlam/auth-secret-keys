<?php

namespace harlam\Security\Auth\Entity;

use DateTime;

/**
 * Interface KeyEntityInterface
 * @package harlam\Security\Auth\Entity
 */
interface KeyEntityInterface
{
    /**
     * @return string
     */
    public function getOwner(): string;

    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return int
     */
    public function getAttempts(): int;

    /**
     * @param int $count
     * @return KeyEntityInterface
     */
    public function incAttempts(int $count = 1): KeyEntityInterface;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime;
}
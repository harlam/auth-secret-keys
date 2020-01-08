<?php

namespace harlam\Security\Auth\Entity;

use DateTime;

interface KeyEntityInterface
{
    /**
     * @return string|null
     */
    public function getUid(): ?string;

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
     * @return DateTime
     */
    public function getCreatedAt(): DateTime;
}
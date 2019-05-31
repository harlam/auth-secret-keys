<?php

namespace harlam\Security\Entity;

use DateTime;

/**
 * Class VerificationCode
 * @package harlam\Security
 */
class VerificationCode
{
    /** @var string Owner */
    protected $owner;
    /** @var string Code */
    protected $code;
    /** @var integer Attempts */
    protected $attempts;
    /** @var DateTime Date/Time */
    protected $createdAt;

    public function __construct()
    {
        $this->owner = '';
        $this->attempts = 0;
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
     * @return VerificationCode
     */
    public function setOwner(string $owner): VerificationCode
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return VerificationCode
     */
    public function setCode($code): VerificationCode
    {
        $this->code = $code;
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
     * @return VerificationCode
     */
    public function setAttempts(int $attempts): VerificationCode
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
     * @return VerificationCode
     */
    public function setCreatedAt(DateTime $createdAt): VerificationCode
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
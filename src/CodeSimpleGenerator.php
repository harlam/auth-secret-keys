<?php

namespace harlam\Security;

use DateTime;
use harlam\Security\Entity\VerificationCode;
use harlam\Security\Interfaces\CodeGeneratorInterface;

class CodeSimpleGenerator implements CodeGeneratorInterface
{
    protected $owner = '';

    /**
     * @param string $owner
     * @return CodeGeneratorInterface
     */
    public function setOwner(string $owner): CodeGeneratorInterface
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return VerificationCode
     */
    public function generate(): VerificationCode
    {
        $code = (string)random_int(100000, 999999);

        return (new VerificationCode())
            ->setOwner($this->owner)
            ->setCode($code)
            ->setCreatedAt(new DateTime());
    }
}
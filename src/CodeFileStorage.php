<?php

namespace harlam\Security\Interfaces;

use harlam\Security\Entity\VerificationCode;
use RuntimeException;

class CodeFileStorage implements CodeStorageInterface
{
    protected $path;

    public function __construct(string $path)
    {
        $this->path = realpath($path);

        if (!is_dir($this->path)) {
            throw new RuntimeException("Initialization error in '{$this->path}'");
        }
    }

    public function find(string $uid): VerificationCode
    {
        $data = file_get_contents($this->path . DIRECTORY_SEPARATOR . $uid);
        return new VerificationCode();
    }

    public function create(VerificationCode $code): VerificationCode
    {
        file_put_contents($this->path . DIRECTORY_SEPARATOR . md5($code->getCode()), json_encode($code));
        return new VerificationCode();
    }

    public function delete(string $uid): bool
    {
        return unlink($this->path . DIRECTORY_SEPARATOR . md5($code->getCode()));
    }
}
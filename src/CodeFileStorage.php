<?php

namespace harlam\Security;

use harlam\Security\Entity\VerificationCode;
use harlam\Security\Interfaces\CodeStorageInterface;
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

    public function find(string $code, string $prefix = ''): VerificationCode
    {
        $data = file_get_contents($this->path . DIRECTORY_SEPARATOR . $prefix . $code);
        var_dump($data);
        return new VerificationCode();
    }

    public function create(VerificationCode $code): VerificationCode
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $code->getPrefix() . $code->getCode();
        $saved = file_put_contents($file, json_encode([
            'prefix' => $code->getPrefix(),
            'code' => $code->getCode(),
            'attempts' => $code->getAttempts(),
            'created' => $code->getCreatedAt()->format('Y-m-d H:i:s'),
        ]));

        if (!$saved) {
            throw new RuntimeException("Save error");
        }

        return $code;
    }

    public function delete(string $code, string $prefix = ''): bool
    {
        return unlink($this->path . DIRECTORY_SEPARATOR . $prefix . $code);
    }
}
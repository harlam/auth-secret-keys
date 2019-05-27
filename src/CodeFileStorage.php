<?php

namespace harlam\Security;

use DateTime;
use harlam\Security\Entity\VerificationCode;
use harlam\Security\Exceptions\StorageException;
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

    public function find(string $code, string $prefix = ''): ?VerificationCode
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $prefix . $code;

        if (!file_exists($file)) {
            return null;
        }

        $data = file_get_contents($file);

        if ($data === false || ($json = json_decode($data)) === false) {
            throw new StorageException("Record read error");
        }

        return (new VerificationCode())
            ->setPrefix($json->prefix)
            ->setCode($json->code)
            ->setAttempts($json->attempts)
            ->setCreatedAt(DateTime::createFromFormat('Y-m-d H:i:s', $json->created));
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

    public function getLast(string $prefix = ''): ?VerificationCode
    {
        $files = glob($this->path . DIRECTORY_SEPARATOR . $prefix . '*', SCANDIR_SORT_DESCENDING);

        var_dump($files);
    }
}
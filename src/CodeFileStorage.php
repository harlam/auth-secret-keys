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

    public function find(string $owner, string $code): ?VerificationCode
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $owner . $code;

        if (!file_exists($file)) {
            return null;
        }

        $data = file_get_contents($file);

        if ($data === false || ($json = json_decode($data)) === false) {
            throw new StorageException("Record read error");
        }

        return (new VerificationCode())
            ->setOwner($json->prefix)
            ->setCode($json->code)
            ->setAttempts($json->attempts)
            ->setCreatedAt(DateTime::createFromFormat('Y-m-d H:i:s', $json->created));
    }

    /**
     * @param VerificationCode $code
     * @return VerificationCode
     */
    public function create(VerificationCode $code): VerificationCode
    {
        $file = $this->path . DIRECTORY_SEPARATOR . $code->getOwner() . $code->getCode();
        $saved = file_put_contents($file, json_encode([
            'owner' => $code->getOwner(),
            'code' => $code->getCode(),
            'attempts' => $code->getAttempts(),
            'created' => $code->getCreatedAt()->format('Y-m-d H:i:s'),
        ]));

        if (!$saved) {
            throw new RuntimeException("Save error");
        }

        return $code;
    }

    /**
     * @param string $code
     * @param string $prefix
     * @return bool
     */
    public function delete(string $code, string $prefix = ''): bool
    {
        return unlink($this->path . DIRECTORY_SEPARATOR . $prefix . $code);
    }

    /**
     * @param string $prefix
     * @return VerificationCode|null
     */
    public function getLast(string $prefix = ''): ?VerificationCode
    {
        $files = glob($this->path . DIRECTORY_SEPARATOR . $prefix . '*', SCANDIR_SORT_DESCENDING);

        var_dump($files);
    }
}
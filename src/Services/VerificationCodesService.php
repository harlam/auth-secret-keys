<?php

namespace harlam\Security\Services;

use harlam\Security\Interfaces\CodeGeneratorInterface;
use harlam\Security\Interfaces\CodeStorageInterface;

class VerificationCodesService
{
    protected $generator;
    protected $storage;

    public function __construct(CodeGeneratorInterface $generator, CodeStorageInterface $storage)
    {
        $this->generator = $generator;
        $this->storage = $storage;
    }

    public function create(): string
    {
        $code = $this->generator->generate();
        $this->storage->create($code);
    }

    public function validate(string $code, string $prefix = ''): bool
    {
        $stored = $this->storage->find($code, $prefix);

        if ($stored === null) {
            // Code not found
        }

    }
}
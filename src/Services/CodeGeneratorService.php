<?php

namespace harlam\Security\Services;

use harlam\Security\Interfaces\CodeGeneratorInterface;
use harlam\Security\Interfaces\CodeStorageInterface;

class CodeGeneratorService
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
}
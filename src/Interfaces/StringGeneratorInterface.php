<?php

namespace harlam\Auth\Secrets\Interfaces;

interface StringGeneratorInterface
{
    public function generate(): string;
}
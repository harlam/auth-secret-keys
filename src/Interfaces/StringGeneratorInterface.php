<?php

namespace harlam\Auth\Secrets\Interfaces;

interface StringGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string;
}
<?php

namespace App\Common\App\Command;

interface CommandInterface
{
    public function getType(): string;

    public function getPayload(): array;

    /**
     * @param string $key
     * @return mixed
     */
    public function getValue(string $key);
}
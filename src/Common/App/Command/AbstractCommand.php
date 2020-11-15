<?php

namespace App\Common\App\Command;

class AbstractCommand implements CommandInterface
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }


    public function getType(): string
    {
        /** @noinspection PhpUndefinedClassConstantInspection */
        return static::TYPE;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}
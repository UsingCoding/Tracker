<?php

namespace App\Common\App\Command;

use App\Common\Domain\Utils\Arrays;

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

    public function getValue(string $key)
    {
        return Arrays::get($this->getPayload(), $key);
    }
}
<?php

namespace App\Common\Api\Exception;

use App\Common\Domain\Utils\Arrays;

abstract class AbstractApiException extends \Exception
{
    public const UNKNOWN_ERROR = 0;

    private int $type;

    private function __construct(int $type, string $message, int $code, \Throwable $previous)
    {
        parent::__construct($message, $code, $previous);

        $this->type = $type;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public static function from(\Throwable $throwable): self
    {
        $type = Arrays::get(static::getExceptionMap() ?? [], get_class($throwable), self::UNKNOWN_ERROR);

        $exceptionClass = static::getSelf();

        return new $exceptionClass($type, $throwable->getMessage(), $throwable->getCode(), $throwable);
    }

    abstract protected static function getSelf(): string;

    abstract protected static function getExceptionMap(): ?array;
}
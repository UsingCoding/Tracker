<?php


namespace App\Module\User\Api\Exception;

use App\Common\Domain\Utils\Arrays;
use App\Module\User\App\Exception\IncorrectUserPasswordException;
use App\Module\User\App\Exception\UserNotFoundException;

class ApiException extends \Exception
{
    public const UNKNOWN_ERROR = 0;
    public const USER_NOT_FOUND = 1;
    public const INCORRECT_PASSWORD = 2;

    private const EXCEPTION_CLASS_CODE_MAP = [
        UserNotFoundException::class => self::USER_NOT_FOUND,
        IncorrectUserPasswordException::class => self::INCORRECT_PASSWORD
    ];

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
        $type = Arrays::get(self::EXCEPTION_CLASS_CODE_MAP, gettype($throwable), self::UNKNOWN_ERROR);

        return new self($type, $throwable->getMessage(), $throwable->getCode(), $throwable);
    }
}
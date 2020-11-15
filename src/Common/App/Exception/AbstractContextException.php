<?php

namespace App\Common\App\Exception;

use App\Common\Domain\Utils\Strings;
use Throwable;

abstract class AbstractContextException extends \Exception
{
    private ?array $context;

    public function __construct($message = "", ?array $context = null, $code = 0, Throwable $previous = null)
    {
        parent::__construct($this->modifyMessageWithContext($message, $context), $code, $previous);

        $this->context = $context;
    }

    public function getContext(): ?array
    {
        return $this->context;
    }

    private function modifyMessageWithContext(string $message, ?array $context): string
    {
        if ($context === null)
        {
            return $message;
        }

        try
        {
            return Strings::trim($message . ' ') . json_encode($context, JSON_THROW_ON_ERROR);
        }
        catch (\JsonException $e)
        {
            return $message;
        }
    }
}
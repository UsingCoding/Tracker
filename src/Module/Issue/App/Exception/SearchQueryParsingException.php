<?php

namespace App\Module\Issue\App\Exception;

use Throwable;

class SearchQueryParsingException extends \Exception
{
    public const VALUE_NOT_SUPPORTED = 0;
    public const UNKNOWN_ORDER_BY_PARAM = 1;

    private int $type;

    public function __construct(int $type, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->type = $type;
    }

    public function getType(): int
    {
        return $this->type;
    }
}
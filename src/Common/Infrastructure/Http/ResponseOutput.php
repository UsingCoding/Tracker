<?php

namespace App\Common\Infrastructure\Http;

class ResponseOutput
{
    private int $statusCode;
    private array $headers;
    private string $content;

    public function __construct(int $statusCode, array $headers, string $content)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->content = $content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return array
     * @throws \JsonException
     */
    public function getJsonDecodedContent(): array
    {
        $decodedValue = json_decode($this->content, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($decodedValue))
        {
            return [$decodedValue];
        }

        return $decodedValue;
    }
}
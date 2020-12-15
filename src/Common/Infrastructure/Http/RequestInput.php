<?php

namespace App\Common\Infrastructure\Http;

class RequestInput
{
    private string $method;
    private string $url;
    private ?array $json;

    public function __construct(string $method, string $url, ?array $json = null)
    {
        $this->method = $method;
        $this->url = $url;
        $this->json = $json;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getJson(): ?array
    {
        return $this->json;
    }
}
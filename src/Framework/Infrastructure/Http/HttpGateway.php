<?php

namespace App\Framework\Infrastructure\Http;

use App\Common\Domain\Utils\Arrays;
use App\Common\Infrastructure\Http\Exception\InvalidHttpRequestException;
use App\Common\Infrastructure\Http\HttpGatewayInterface;
use App\Common\Infrastructure\Http\RequestInput;
use App\Common\Infrastructure\Http\ResponseOutput;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class HttpGateway implements HttpGatewayInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function request(RequestInput $input): ResponseOutput
    {
        try
        {
            $this->logger->debug('Request', ['method' => $input->getMethod(), 'url' => $input->getUrl()]);

            $response = HttpClient::create()->request($input->getMethod(), $input->getUrl(), (array)Arrays::removeNulls([
                'json' => $input->getJson()
            ]));

            $this->logger->debug('Response', [
                'code' => $response->getStatusCode(),
                'headers' => $response->getHeaders(false),
                'body' => $response->getContent(false)
            ]);

            return new ResponseOutput(
                $response->getStatusCode(),
                $response->getHeaders(false),
                $response->getContent(false)
            );
        }
        catch (ExceptionInterface $e)
        {
            $this->logger->debug('Failed to make request due to exception', ['ex' => (string) $e]);

            throw new InvalidHttpRequestException($e->getMessage(), [
                'url' => $input->getUrl(),
                'method' => $input->getMethod()
            ], $e->getCode(), $e);
        }
    }
}
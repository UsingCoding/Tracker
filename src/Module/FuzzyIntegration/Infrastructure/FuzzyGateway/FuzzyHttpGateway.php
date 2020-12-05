<?php

namespace App\Module\FuzzyIntegration\Infrastructure\FuzzyGateway;

use App\Common\Domain\Utils\Arrays;
use App\Common\Infrastructure\Http\Exception\InvalidHttpRequestException;
use App\Common\Infrastructure\Http\HttpGatewayInterface;
use App\Common\Infrastructure\Http\RequestInput;
use App\Common\Infrastructure\Http\RequestMethod;
use App\Common\Infrastructure\Http\ResponseCode;
use App\Module\FuzzyIntegration\App\Exception\InvalidServiceRequestException;
use App\Module\FuzzyIntegration\App\Exception\UnexpectedServiceResponseException;
use App\Module\FuzzyIntegration\App\Service\FuzzyGatewayServiceInterface;

class FuzzyHttpGateway implements FuzzyGatewayServiceInterface
{
    private HttpGatewayInterface $httpGateway;
    private string $microserviceUrl;
    private array $urlsMapping;

    public function __construct(HttpGatewayInterface $httpGateway, string $microserviceUrl, array $urlsMapping)
    {
        $this->httpGateway = $httpGateway;
        $this->microserviceUrl = $microserviceUrl;
        $this->urlsMapping = $urlsMapping;
    }

    public function calculate(int $difficulty, int $time): int
    {
        try
        {
            $response = $this->httpGateway->request(new RequestInput(
                RequestMethod::POST,
                $this->mergeUrl(Arrays::get($this->urlsMapping, 'calculate')),
                [
                    'difficulty' => $difficulty,
                    'time' => $time
                ]
            ));

            if ($response->getStatusCode() !== ResponseCode::OK)
            {
                throw new UnexpectedServiceResponseException('Unexpected fuzzy service response', $response->getStatusCode());
            }

            $content = $response->getJsonDecodedContent();

            if (!Arrays::hasKey($content, 'result'))
            {
                throw new UnexpectedServiceResponseException('No result returned', $response->getStatusCode());
            }

            return Arrays::get($content, 'result');
        }
        catch (InvalidHttpRequestException $e)
        {
            throw new InvalidServiceRequestException($e->getMessage(), $e->getCode(), $e);
        }
        catch (\JsonException $e)
        {
            throw new UnexpectedServiceResponseException('Failed to parse response');
        }
    }

    private function mergeUrl(string $url): string
    {
        return $this->microserviceUrl . $url;
    }
}
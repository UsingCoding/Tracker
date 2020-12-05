<?php

namespace App\Common\Infrastructure\Http;

use App\Common\Infrastructure\Http\Exception\InvalidHttpRequestException;

interface HttpGatewayInterface
{
    /**
     * @param RequestInput $input
     * @return ResponseOutput
     * @throws InvalidHttpRequestException
     */
    public function request(RequestInput $input): ResponseOutput;
}
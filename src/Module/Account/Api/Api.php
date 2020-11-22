<?php

namespace App\Module\Account\Api;

use App\Module\Account\Api\Exception\ApiException;
use App\Module\Account\Api\Mapper\AccountMapper;
use App\Module\Account\Api\Output\AccountOutput;
use App\Module\Account\App\Query\AccountQueryServiceInterface;

class Api implements ApiInterface
{
    private AccountQueryServiceInterface $accountQueryService;

    public function __construct(AccountQueryServiceInterface $accountQueryService)
    {
        $this->accountQueryService = $accountQueryService;
    }

    public function getAccountByDomain(string $domainName): AccountOutput
    {
        try
        {
            return AccountMapper::getAccountOutput($this->accountQueryService->getByDomainName($domainName));
        }
        catch (\Throwable $e)
        {
            ApiException::from($e);
        }
    }
}
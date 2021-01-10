<?php

namespace App\Module\Account\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Module\Account\Api\Exception\ApiException;
use App\Module\Account\Api\Mapper\AccountMapper;
use App\Module\Account\Api\Output\AccountOutput;
use App\Module\Account\App\Command\CreateAccountCommand;
use App\Module\Account\App\Query\AccountQueryServiceInterface;

class Api implements ApiInterface
{
    private AppCommandBusInterface $commandBus;
    private AccountQueryServiceInterface $accountQueryService;

    public function __construct(AppCommandBusInterface $commandBus, AccountQueryServiceInterface $accountQueryService)
    {
        $this->commandBus = $commandBus;
        $this->accountQueryService = $accountQueryService;
    }

    public function createAccount(CreateAccountInput $input): void
    {
        $command = new CreateAccountCommand($input);

        $this->publish($command);
    }

    public function getAccount(): AccountOutput
    {
        try
        {
            $account = $this->accountQueryService->get();

            return AccountMapper::getAccountOutput($account);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }



    private function publish(CommandInterface $command): void
    {
        try
        {
            $this->commandBus->publish($command);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }
}
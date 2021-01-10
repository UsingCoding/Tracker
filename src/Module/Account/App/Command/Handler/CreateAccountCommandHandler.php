<?php

namespace App\Module\Account\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Account\App\Command\CreateAccountCommand;
use App\Module\Account\Domain\Service\AccountService;

class CreateAccountCommandHandler implements AppCommandHandlerInterface
{
    private SynchronizationInterface $synchronization;
    private AccountService $service;

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof CreateAccountCommand)
        {
            throw new InvalidCommandException('Invalid command provided for handle', ['expected_command' => CreateAccountCommand::class]);
        }

        $payload = $command->getPayload();

        $this->synchronization->transaction(fn() =>
            $this->service->createAccount(Arrays::get($payload, CreateAccountCommand::OWNER_ID))
        );
    }
}
<?php

namespace App\Module\Project\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Project\App\Command\AddTeamMemberCommand;
use App\Module\Project\Domain\Service\TeamMemberService;

class AddTeamMemberCommandHandler implements AppCommandHandlerInterface
{
    private SynchronizationInterface $synchronization;
    private TeamMemberService $service;

    public function __construct(SynchronizationInterface $synchronization, TeamMemberService $service)
    {
        $this->synchronization = $synchronization;
        $this->service = $service;
    }

    public function execute(CommandInterface $command): void
    {
        if (!$command instanceof AddTeamMemberCommand)
        {
            throw new InvalidCommandException('Invalid command provided for handle', ['expected_command' => AddTeamMemberCommand::class]);
        }

        $payload = $command->getPayload();

        $this->synchronization->transaction(fn() => $this->service->addMember(
            Arrays::get($payload, AddTeamMemberCommand::PROJECT_ID),
            Arrays::get($payload, AddTeamMemberCommand::USER_ID)
        ));
    }
}
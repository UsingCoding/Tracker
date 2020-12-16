<?php

namespace App\Module\Project\App\Command\Handler;

use App\Common\App\Command\CommandInterface;
use App\Common\App\Command\Handler\AppCommandHandlerInterface;
use App\Common\App\Exception\InvalidCommandException;
use App\Common\App\Synchronization\SynchronizationInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Project\App\Command\RemoveTeamMemberCommand;
use App\Module\Project\Domain\Service\TeamMemberService;

class RemoveTeamMemberCommandHandler implements AppCommandHandlerInterface
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
        if (!$command instanceof RemoveTeamMemberCommand)
        {
            throw new InvalidCommandException('Invalid command provided for handle', ['expected_command' => RemoveTeamMemberCommand::class]);
        }

        $payload = $command->getPayload();

        $this->synchronization->transaction(fn() => $this->service->removeMember(
            Arrays::get($payload, RemoveTeamMemberCommand::TEAM_MEMBER_ID)
        ));
    }
}
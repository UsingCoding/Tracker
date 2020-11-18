<?php

namespace App\Module\Issue\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\CreateIssueInput;
use App\Module\Issue\App\Command\CreateIssueCommand;

class Api implements ApiInterface
{
    private AppCommandBusInterface $issueCommandBus;

    public function __construct(AppCommandBusInterface $issueCommandBus)
    {
        $this->issueCommandBus = $issueCommandBus;
    }

    public function createIssue(CreateIssueInput $input): int
    {
        $command = new CreateIssueCommand($input);

        $this->publish($command);

        return 1;
    }

    /**
     * @param CommandInterface $command
     * @throws ApiException
     */
    private function publish(CommandInterface $command): void
    {
        try
        {
            $this->issueCommandBus->publish($command);
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }
}
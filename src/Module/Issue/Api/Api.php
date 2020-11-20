<?php

namespace App\Module\Issue\Api;

use App\Common\App\Command\Bus\AppCommandBusInterface;
use App\Common\App\Command\CommandInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\CreateIssueInput;
use App\Module\Issue\Api\Mapper\IssueOutputMapper;
use App\Module\Issue\Api\Output\GetIssueOutput;
use App\Module\Issue\App\Command\CreateIssueCommand;
use App\Module\Issue\App\Query\IssueQueryServiceInterface;

class Api implements ApiInterface
{
    private AppCommandBusInterface $issueCommandBus;
    private IssueQueryServiceInterface $issueQueryService;

    public function __construct(AppCommandBusInterface $issueCommandBus, IssueQueryServiceInterface $issueQueryService)
    {
        $this->issueCommandBus = $issueCommandBus;
        $this->issueQueryService = $issueQueryService;
    }

    public function createIssue(CreateIssueInput $input): int
    {
        $command = new CreateIssueCommand($input);

        $this->publish($command);

        return 1;
    }

    public function getIssue(string $code): ?GetIssueOutput
    {
        try
        {
            $issueData = $this->issueQueryService->getIssue($code);

            if ($issueData === null)
            {
                return null;
            }

            return IssueOutputMapper::getIssueOutput($issueData);
        }
        catch (\Throwable $e)
        {
            throw ApiException::from($e);
        }
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
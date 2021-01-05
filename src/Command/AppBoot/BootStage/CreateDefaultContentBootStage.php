<?php

namespace App\Command\AppBoot\BootStage;

use App\Command\AppBoot\Exception\BootStageExecutionFailedException;
use App\Common\Domain\Utils\Arrays;
use App\Framework\Infrastructure\Command\ApplicationProviderInterface;
use App\Module\Project\Api\ApiInterface as ProjectApi;
use App\Module\Project\Api\Exception\ApiException as ProjectApiException;
use App\Module\Project\Api\Input\CreateProjectInput;
use App\Module\User\Api\ApiInterface as UserApi;
use App\Module\User\Api\Exception\ApiException as UserApiException;
use App\Module\User\Api\Input\AddUserInput;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDefaultContentBootStage implements BootStageInterface
{
    private UserApi $userApi;
    private ProjectApi $projectApi;
    private LoggerInterface $logger;

    public function __construct(UserApi $userApi, ProjectApi $projectApi, LoggerInterface $logger)
    {
        $this->userApi = $userApi;
        $this->projectApi = $projectApi;
        $this->logger = $logger;
    }

    public function execute(OutputInterface $output, ApplicationProviderInterface $applicationProvider): void
    {
        try
        {
            if (!$this->needToCreateDefaultContent())
            {
                $this->logger->notice('Creating default content canceled');
                return;
            }

            $this->createUser();
            $this->createProject();
        }
        catch (\Throwable $throwable)
        {
            throw new BootStageExecutionFailedException();
        }
    }

    /**
     * @return bool
     * @throws UserApiException
     */
    private function needToCreateDefaultContent(): bool
    {
        return Arrays::length($this->userApi->list()->getUsers()) === 0;
    }

    /**
     * @throws UserApiException
     */
    private function createUser(): void
    {
        $this->userApi->addUser(new AddUserInput(
            'example@mail.com',
            'root',
            '12345Q',
            3,
            null
        ));
    }

    /**
     * @throws ProjectApiException
     */
    private function createProject(): void
    {
        $this->projectApi->createProject(new CreateProjectInput(
            'Default',
            'PANDA',
            1,
            null
        ));
    }
}
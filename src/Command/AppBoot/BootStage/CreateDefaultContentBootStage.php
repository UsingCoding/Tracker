<?php

namespace App\Command\AppBoot\BootStage;

use App\Command\AppBoot\Exception\BootStageExecutionFailedException;
use App\Common\Domain\Utils\Arrays;
use App\Framework\Infrastructure\Command\ApplicationProviderInterface;
use App\Module\Account\Api\ApiInterface as AccountApi;
use App\Module\Account\Api\CreateAccountInput;
use App\Module\Account\Api\Exception\ApiException as AccountApiException;
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
    private AccountApi $accountApi;
    private ProjectApi $projectApi;
    private LoggerInterface $logger;

    public function __construct(UserApi $userApi, AccountApi $accountApi, ProjectApi $projectApi, LoggerInterface $logger)
    {
        $this->userApi = $userApi;
        $this->accountApi = $accountApi;
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

            $userId = $this->createUser();

            $this->createAccount($userId);
            $this->createProject($userId);
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
     * @return int
     * @throws UserApiException
     */
    private function createUser(): int
    {
        return $this->userApi->addUser(new AddUserInput(
            'mail@mail.com',
            'root',
            '12345Q',
            3,
            null
        ));
    }

    /**
     * @param int $ownerId
     * @throws AccountApiException
     */
    public function createAccount(int $ownerId): void
    {
        $this->accountApi->createAccount(new CreateAccountInput($ownerId));
    }

    /**
     * @param int $ownerId
     * @throws ProjectApiException
     */
    private function createProject(int $ownerId): void
    {
        $this->projectApi->createProject(new CreateProjectInput(
            'Default',
            'PANDA',
            $ownerId,
            null
        ));
    }
}
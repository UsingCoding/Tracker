<?php

namespace App\Command\AppBoot\BootStage;

use App\Command\AppBoot\Exception\BootStageExecutionFailedException;
use App\Framework\Infrastructure\Command\ApplicationProviderInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface BootStageInterface
{
    /**
     * @param OutputInterface $output
     * @param ApplicationProviderInterface $applicationProvider
     * @return mixed
     * @throws BootStageExecutionFailedException
     */
    public function execute(OutputInterface $output, ApplicationProviderInterface $applicationProvider): void;
}
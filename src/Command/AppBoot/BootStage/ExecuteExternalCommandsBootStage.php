<?php

namespace App\Command\AppBoot\BootStage;

use App\Command\AppBoot\Exception\BootStageExecutionFailedException;
use App\Common\Domain\Utils\Arrays;
use App\Framework\Infrastructure\Command\ApplicationProviderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\OutputInterface;

class ExecuteExternalCommandsBootStage implements BootStageInterface
{
    private const NAME_KEY = 'name';
    private const ARGS_KEY = 'args';

    private array $commands;
    private LoggerInterface $logger;

    public function __construct(array $commands, LoggerInterface $logger)
    {
        $this->commands = $commands;
        $this->logger = $logger;
    }

    public function execute(OutputInterface $output, ApplicationProviderInterface $applicationProvider): void
    {
        foreach ($this->commands as $commandData)
        {
            $commandName = Arrays::get($commandData, self::NAME_KEY);

            try
            {
                $command = $applicationProvider->getApplication()->find($commandName);

                $input = new ArgvInput(Arrays::merge(
                    [
                        'command' => $commandName
                    ],
                    $this->prepareArgs(Arrays::get($commandData, self::ARGS_KEY, []))
                ));

                $input->setInteractive(false);

                $code = $command->run($input, $output);

                if ($code !== SymfonyCommand::SUCCESS)
                {
                    $output->writeln('Command ' . $commandName . ' execution failed');

                    $this->logger->error('Command exited with nonzero code', ['command' => $commandName, 'code' => $code]);

                    throw new BootStageExecutionFailedException();
                }
            }
            catch (CommandNotFoundException $exception)
            {
                $output->writeln('Command ' . $commandName . ' not found');

                $this->logger->error('Command from bootstrap list not found', ['command' => $commandName]);

                throw new BootStageExecutionFailedException();
            }
            catch (\Throwable $throwable)
            {
                $output->writeln('Command ' . $commandName . ' execution failed due to: ' . $throwable->getMessage());

                $this->logger->error('Command execution failed due to exception', ['command' => $commandName, 'ex' => $throwable]);

                throw new BootStageExecutionFailedException();
            }
        }
    }

    private function prepareArgs(array $args): array
    {
        $result = [];

        foreach ($args as $key => $value)
        {
            if ($value === null)
            {
                $result[] = $key;
                continue;
            }

            $result[$key] = $value;
        }

        return $result;
    }
}
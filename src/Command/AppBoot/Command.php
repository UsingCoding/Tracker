<?php

namespace App\Command\AppBoot;

use App\Command\AppBoot\BootStage\BootStageInterface;
use App\Framework\Infrastructure\Command\ApplicationProviderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class Command extends SymfonyCommand implements ApplicationProviderInterface
{
    private const DATE_LOG_FORMAT = 'd M Y G:i:s.u';
    private const PROD_ENV = 'prod';

    private string $environment;
    /** @var BootStageInterface[] */
    private array $stages;
    private LoggerInterface $logger;

    public function __construct(string $environment, array $stages, LoggerInterface $logger)
    {
        $this->environment = $environment;
        $this->stages = $stages;
        $this->logger = $logger;

        parent::__construct();
    }

    public function getApplication(): Application
    {
        return parent::getApplication();
    }

    protected function configure(): void
    {
        $this->setName('app:boot');

        $this->addOption('force', 'f', InputOption::VALUE_NONE, 'Forces execution of command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->environment === self::PROD_ENV && $input->getOption('force') === false)
        {
            $this->logger->info('No environment bootstrap executed');

            $output->writeln('Skipping bootstrap');

            return self::SUCCESS;
        }

        $this->logger->info('Environment bootstrap executed at ' . (new \DateTimeImmutable())->format(self::DATE_LOG_FORMAT));

        /** @var BootStageInterface|null $failedStage */
        $failedStage = null;
        /** @var Throwable|null $exception */
        $exception = null;

        foreach ($this->stages as $stage)
        {
            try
            {
                $stage->execute($output, $this);
            }
            catch (Throwable $e)
            {
                $failedStage = $stage;

                $exception = $e;

                break;
            }
        }

        if ($failedStage !== null)
        {
            $this->logger->info('Environment bootstrap stop executing with fail at ' .
                (new \DateTimeImmutable())->format(self::DATE_LOG_FORMAT),
                [
                    'stage' => get_class($failedStage),
                    'ex' => $exception
                ]
            );

            return SymfonyCommand::FAILURE;
        }

        $this->logger->info('Environment bootstrap stop executing successfully at ' .
            (new \DateTimeImmutable())->format(self::DATE_LOG_FORMAT)
        );

        return SymfonyCommand::SUCCESS;
    }
}
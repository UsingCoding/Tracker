<?php

namespace App\Framework\Infrastructure\Listener;

use App\Common\App\Synchronization\ScheduledJobsQueueInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ScheduledJobsQueueTerminateEventListener implements ScheduledJobsQueueInterface, EventSubscriberInterface
{
    /** @var callable[] */
    private array $jobs = [];
    private LoggerInterface $logger;

    public function addJob(callable $job)
    {
        $this->jobs[] = $job;
    }

    public function onKernelTerminate(TerminateEvent $event): void
    {
        foreach ($this->jobs as $job)
        {
            try
            {
                $job();
            }
            catch (\Throwable $throwable)
            {
                $this->logger->error('Scheduled job failed with exception', ['ex' => $throwable]);
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::TERMINATE => ['onKernelTerminate', 5]
        ];
    }

}
<?php

namespace App\Common\App\Synchronization;

interface ScheduledJobsQueueInterface
{
    /**
     * @param callable $job
     * @return mixed
     */
    public function addJob(callable $job);
}
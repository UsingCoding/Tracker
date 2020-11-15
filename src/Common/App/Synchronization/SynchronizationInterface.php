<?php

namespace App\Common\App\Synchronization;

use Throwable;

interface SynchronizationInterface
{
    /**
     * @param callable $job
     * @return mixed
     * @throws Throwable
     */
    public function transaction(callable $job);

    /**
     * @param string $lockName
     * @param callable $job
     * @return mixed
     * @throws Throwable
     */
    public function lockWithTransaction(string $lockName, callable $job);
}
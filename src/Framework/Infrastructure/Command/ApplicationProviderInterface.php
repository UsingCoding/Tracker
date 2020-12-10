<?php

namespace App\Framework\Infrastructure\Command;

use Symfony\Component\Console\Application;

interface ApplicationProviderInterface
{
    public function getApplication(): Application;
}
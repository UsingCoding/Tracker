<?php

namespace App\Common\App\Hydration;

interface HydratorInterface
{
    public function hydrate(array $row, array &$result): void;
    public function hydrateAll(array $rows): array;
}
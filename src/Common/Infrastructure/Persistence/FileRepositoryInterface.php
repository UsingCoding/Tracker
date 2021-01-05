<?php

namespace App\Common\Infrastructure\Persistence;

use App\Common\App\Exception\CantStoreFileException;

interface FileRepositoryInterface
{
    /**
     * @param string $path
     * @param string $extension
     * @param string $idPrefix
     * @return string relative path
     * @throws CantStoreFileException
     */
    public function store(string $path, string $extension, string $idPrefix = ''): string;
}
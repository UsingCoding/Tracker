<?php

namespace App\Framework\Infrastructure\Persistence\File;

use App\Common\App\Exception\CantStoreFileException;
use App\Common\Infrastructure\Persistence\FileRepositoryInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

class FileSystemFileRepository implements FileRepositoryInterface
{
    private string $dirPath;

    public function __construct(string $dirPath)
    {
        $this->dirPath = $dirPath;
    }

    public function store(string $path, string $extension, string $idPrefix = ''): string
    {
        $file = new File($path);

        try
        {
            $newFile = $file->move($this->dirPath, uniqid($idPrefix, true) . '.' . $extension);
        }
        catch (FileException $exception)
        {
            throw new CantStoreFileException($exception->getMessage(), [], $exception->getCode(), $exception);
        }

        return $newFile->getFilename();
    }
}
<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class FilesystemFileDeleter implements FileDeleter
{
    private $filesystem;

    private $filePath;

    public function __construct(Filesystem $filesystem, string $filePath)
    {
        $this->filesystem = $filesystem;
        $this->filePath   = $filePath;
    }

    public function delete($pathToFile)
    {
        $this->filesystem->remove(
            $this->filePath . '/' . $pathToFile
        );
    }

    public function getFilePath()
    {
        return $this->filePath;
    }
}
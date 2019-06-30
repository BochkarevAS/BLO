<?php

declare(strict_types=1);

namespace App\Service;

use Gaufrette\Filesystem;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;

class FileDeleter
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var CacheManager
     */
    protected $cacheManager;

    public function __construct(Filesystem $filesystem, CacheManager $cacheManager)
    {
        $this->filesystem   = $filesystem;
        $this->cacheManager = $cacheManager;
    }

    public function delete(string $file)
    {
        if ($this->filesystem->has($file))  {
            $this->filesystem->delete($file);
            $this->cacheManager->remove($file);
        }
    }
}
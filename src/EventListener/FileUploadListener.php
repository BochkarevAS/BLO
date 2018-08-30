<?php

namespace App\EventListener;

use App\Entity\Parts\Part;
use App\Entity\Tyres\Tyre;
use App\Service\FilesystemFileDeleter;
use App\Service\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploadListener
{
    private $uploader;

    private $deleter;

    public function __construct(FileUploader $uploader, FilesystemFileDeleter $deleter)
    {
        $this->uploader = $uploader;
        $this->deleter  = $deleter;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Tyre && !$entity instanceof Part) {
            return;
        }

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Tyre && !$entity instanceof Part) {
            return;
        }

        $changes = $args->getEntityChangeSet();

        if (array_key_exists("image", $changes)) {
            $files = $changes["image"][0];
            $this->removeFile($files);
        }

        $this->uploadFile($entity);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Tyre && !$entity instanceof Part) {
            return;
        }

        $files = $entity->getImage();
        $this->removeFile($files);

        $entity->setImage(null);
    }

    private function uploadFile($entity)
    {
        $item = null;
        $files = $entity->getImage();

        if (is_array($files) && isset($files[0])) {
            $item = $files[0];
        }

        if ($item instanceof UploadedFile) {
            $files = $this->uploader->uploadMultiple($files, $this->deleter->getFilePath());
            $json = json_encode($files);
            $entity->setImage($json);
        }
    }

    private function removeFile($files)
    {
        if (!is_array($files)) {
            $files = explode(',', $files);
        }

        foreach ($files as $file) {
            $file = trim($file, '[]""');
            $this->deleter->delete($file);
        }
    }
}
<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Enqueue\Util\JSON;
use Gaufrette\Filesystem;
use Interop\Queue\Message;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader implements FileUploaderInterface
{
    protected $filesystem;

    /**
     * @var EntityManager
     */
    protected $em;

    protected $images;

    public function __construct(Filesystem $filesystem, EntityManagerInterface $em, string $images)
    {
        $this->filesystem = $filesystem;
        $this->em         = $em;
        $this->images     = $images;
    }

    public function upload(UploadedFile $file): string
    {
        $adapter  = $this->filesystem->getAdapter();
        $filename = md5(uniqid()) . '.' . $file->guessExtension();

        /**
         * Всё то же самое что и UploadedFile $file->move($this->getParameter('images'), $filename); Только незовисемо от файловой системы Local или AWS S3.
         */
        $adapter->write($filename, file_get_contents($file->getPathname()));

        return $filename;
    }

    public function uploadMultiple(array $files): array
    {
        $adapter = $this->filesystem->getAdapter();
        $names   = [];

        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $names[]  = $filename;

            /**
             * Всё то же самое что и UploadedFile $file->move($this->getParameter('images'), $filename); Только незовисемо от файловой системы Local или AWS S3.
             */
            $adapter->write($filename, file_get_contents($file->getPathname()));
            unset($file);
        }

        return $names;
    }

    /**
     * Скачивание картинок.
     *
     * @param Message $message
     * @return bool
     */
    public function uploadPicture(Message $message): bool
    {
        $body = JSON::decode($message->getBody());
        $id   = $body['id'];
        $type = $body['entity'];

        $entity = $this->em->find($type, $id);
        $files  = [];

        $adapter = $this->filesystem->getAdapter();

        /**
         * Если сущность из БД удалили тогда то что относится к этой сущности в очереди игнорируется
         */
        if (empty($entity)) {
            return false;
        }

        foreach ($entity->getLinks() as $url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_exec($ch);

            if (200 === curl_getinfo($ch, CURLINFO_RESPONSE_CODE)) {
                $filename = md5(uniqid()) . '.jpg';
                $files[]  = $filename;
                $adapter->write($filename, file_get_contents($url));
            }
        }

        $entity->setImages($files);
        $this->em->merge($entity);
        $this->em->flush();

        return true;
    }
}
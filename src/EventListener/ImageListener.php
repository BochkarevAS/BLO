<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Parts\Part;
use App\Service\FileDeleter;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Enqueue\Client\Message;
use Enqueue\Client\ProducerInterface;
use Enqueue\Util\JSON;

/**
 * Сработает после добавления или изменения продукта в БД.
 */
class ImageListener
{
    private $deleter;

    private $producer;

    public function __construct(FileDeleter $deleter, ProducerInterface $producer)
    {
        $this->deleter  = $deleter;
        $this->producer = $producer;
    }

    /**
     * На данном этапи можно вносить изменения в сущность
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Part) {
            return;
        }

        if (empty($entity->getHash())) {
            $entity->setLinks([]);
        }
    }

    /**
     * При отправки в очередь. На этом событии будет доступно ID сущности. Изменения в сущность вносить уже нельзя
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Part) {
            return;
        }

        $this->uploadFile($entity);
    }

    /**
     * При обновлении сущности. Сработает только для частного лица.
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Part) {
            return;
        }

        if (null !== $entity->getHash()) {
            return;
        }

        $changes = $args->getEntityChangeSet();

        /**
         * При обновление картинки через консольные команды это считается вообще как новая запись (так как в таком случае обновится HASH) и в током случае будет создано новое объявление.
         * Это обновление для частных лиц.
         */
        if (array_key_exists('images', $changes)) {

            /** Достаем старое и новое значение */
            list ($oldImage, $newImage) = $changes['images'];

            $oldImage = JSON::decode($oldImage);
            $newImage = JSON::decode($newImage);

            /** На тот случай если в поле image не выбрано ничего будут оставатся прежние картинки */
            if (empty($newImage)) {
                $entity->setImages($oldImage);

                return;
            }

            $this->removeFile($oldImage);
        }
    }

    /**
     * При удалении сущности.
     * Картинки будут собератся в очередь aImageRemoveCommand.
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Part) {
            return;
        }

        if (!empty($entity->getImages())) {
            $message = new Message();
            $message->setBody(['images' => $entity->getImages()]);
            $this->producer->sendCommand('aImageRemoveCommand', $message);
        }
    }

    /**
     * Отправка данных в очередь
     * Оброботка катринок которые грузятся через консольные команды.
     */
    private function uploadFile($entity)
    {
        if (!empty($entity->getLinks())) {
            $message = new Message();
            $message->setBody(['id' => $entity->getId(), 'entity' => get_class($entity)]);
            $this->producer->sendCommand('aImageCommand', $message);
        }
    }

    /**
     * Удаление картинок с сервера
     */
    private function removeFile(array $files)
    {
        foreach ($files as $file) {
            $this->deleter->delete($file);
        }
    }
}
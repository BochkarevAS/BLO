<?php

namespace App\EventListener;

use App\Entity\Tyres\Tyre;
use Doctrine\ORM\EntityManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;

class UploadListener
{
    protected $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $file = $event->getFile();


//        die;

//        $object = new Tyre();
//        $object->setPicture($file->getPathName());
//
//        $this->manager->persist($object);
//        $this->manager->flush();

        $response = $event->getResponse();
        $response['success'] = true;

        return $response;
    }
}
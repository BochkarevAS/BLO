<?php

namespace App\EventListener;

use App\Entity\Client\Price;
use Doctrine\ORM\EntityManagerInterface;
use Oneup\UploaderBundle\Event\PostPersistEvent;

class PriceUploadListener
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $file = $event->getFile();
        $request = $event->getRequest();

        dump($event);
//        die;
//
//        $price = new Price();
//        $price->setFile($file->getPathName());
//
//        $this->em->persist($price);
//        $this->em->flush();
//
        $response = $event->getResponse();
        $response['success'] = true;

        return $response;
    }
}
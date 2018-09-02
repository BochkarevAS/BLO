<?php

namespace App\EventListener;

use App\Entity\Auth\User;
use App\Entity\Client\Company;
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
        $request = $event->getRequest();
        $company = $request->get('company');
        $user = $request->get('user');
        $file = $event->getFile();

        $company = $this->em->getRepository(Company::class)->find($company);
        $user = $this->em->getRepository(User::class)->find($user);

        $price = new Price();
        $price->setCompany($company);
        $price->setUser($user);
        $price->setFile($file->getPathName());

        $this->em->persist($price);
        $this->em->flush();

        $response = $event->getResponse();
        $response['success'] = true;

        return $response;
    }
}
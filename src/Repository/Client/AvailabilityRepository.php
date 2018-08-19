<?php

namespace App\Repository\Client;

use Doctrine\ORM\EntityRepository;

class AvailabilityRepository extends EntityRepository
{
    public function findByName($name)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('upper(a.name) = upper(:name)')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
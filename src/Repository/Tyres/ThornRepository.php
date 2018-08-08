<?php

namespace App\Repository\Tyres;

use Doctrine\ORM\EntityRepository;

class ThornRepository extends EntityRepository
{
    public function findByName($name)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('upper(t.name) = upper(:name)')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
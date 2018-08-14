<?php

namespace App\Repository\Tyres;

use Doctrine\ORM\EntityRepository;

class СonditionRepository extends EntityRepository
{
    public function findByName($name)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('upper(b.name) = upper(:name)')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
<?php

namespace App\Repository\Client;

use Doctrine\ORM\EntityRepository;

class ConditionRepository extends EntityRepository
{
    public function findByName($name)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('upper(c.name) = upper(:name)')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
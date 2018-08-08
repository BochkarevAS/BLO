<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    public function findByName($name)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('upper(m.name) = upper(:name)')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
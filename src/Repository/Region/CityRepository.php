<?php

namespace App\Repository\Region;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');
    }

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
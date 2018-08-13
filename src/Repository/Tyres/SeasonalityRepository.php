<?php

namespace App\Repository\Tyres;

use Doctrine\ORM\EntityRepository;

class SeasonalityRepository extends EntityRepository
{
    public function findByName($name)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('upper(s.name) = upper(:name)')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
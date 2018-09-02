<?php

namespace App\Repository\Part;

use Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.name', 'ASC');
    }

    public function findByName($name)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('upper(b.name) = upper(:name)')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
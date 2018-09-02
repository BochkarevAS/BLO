<?php

namespace App\Repository\Part;

use Doctrine\ORM\EntityRepository;

class CarcaseRepository extends EntityRepository
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
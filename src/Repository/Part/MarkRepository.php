<?php

namespace App\Repository\Part;

use Doctrine\ORM\EntityRepository;

class MarkRepository extends EntityRepository
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
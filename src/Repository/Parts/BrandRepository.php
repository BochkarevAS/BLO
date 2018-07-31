<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.display!=0')
            ->orderBy('b.name', 'ASC');
    }

    public function findAllByNames(array $names = [])
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->execute();
    }
}
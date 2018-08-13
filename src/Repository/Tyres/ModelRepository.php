<?php

namespace App\Repository\Tyres;

use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    }

    public function findByName($name)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('upper(m.name) = upper(:name)')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllByNames($names)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('upper(m.name) IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->execute();
    }
}
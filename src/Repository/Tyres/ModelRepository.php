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

    public function getModelById($id)
    {
        return $this->createQueryBuilder('m')
            ->Join('m.parts', 'p')
            ->Join('p.brands', 'b')
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
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
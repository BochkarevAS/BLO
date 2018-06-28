<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
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
}
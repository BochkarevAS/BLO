<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class CarcaseRepository extends EntityRepository
{
    public function getCarcaseById($id)
    {
        return $this->createQueryBuilder('c')
            ->Join('c.parts', 'p')
            ->Join('p.models', 'm')
            ->andWhere('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }

    public function findAllByNames($names)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->execute();
    }
}
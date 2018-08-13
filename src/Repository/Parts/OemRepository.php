<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class OemRepository extends EntityRepository
{
    public function findAllByNames($names)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('upper(o.name) IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->execute();
    }
}
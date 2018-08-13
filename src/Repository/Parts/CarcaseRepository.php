<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class CarcaseRepository extends EntityRepository
{
    public function findAllByNames($names)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('upper(c.name) IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->execute();
    }
}
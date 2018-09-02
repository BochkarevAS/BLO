<?php

namespace App\Repository\Part;

use Doctrine\ORM\EntityRepository;

class EngineRepository extends EntityRepository
{
    public function findAllByNames($names)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('upper(e.name) IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->execute();
    }
}
<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class EngineRepository extends EntityRepository
{
    public function findAllByNames($names)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->execute();
    }
}
<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class RegionRepository extends EntityRepository
{
    /**
     * Получение региона по id департамента.
     */
    public function findRegionByDepartment(int $id)
    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.department=:id')
//            ->setParameter('id', $id)
//            ->getQuery()
//            ->getResult();
    }
}
<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class DepartmentRepository extends EntityRepository
{
    /**
     * Получение департамента по id региона.
     */
    public function findDepartmentByRegion(int $id)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.region=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
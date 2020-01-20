<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
    /**
     * Получение города по id департамента.
     */
    public function findCityByDepartment(int $id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.department=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
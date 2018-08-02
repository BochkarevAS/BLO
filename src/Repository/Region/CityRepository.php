<?php

namespace App\Repository\Region;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');
    }
}
<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');
    }
}
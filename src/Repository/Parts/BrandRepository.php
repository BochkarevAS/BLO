<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.display!=0')
            ->orderBy('b.name', 'ASC');
    }
}
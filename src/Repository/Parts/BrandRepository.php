<?php

namespace App\Repository\Parts;

use Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    }
}
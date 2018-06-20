<?php

namespace App\Repository\Part;

use Doctrine\ORM\EntityRepository;

class BrandRepository extends EntityRepository
{
    public function setOrderBy()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    }
}
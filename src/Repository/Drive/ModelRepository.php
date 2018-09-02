<?php

namespace App\Repository\Drive;

use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    }
}
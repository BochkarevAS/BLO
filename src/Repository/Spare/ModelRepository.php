<?php

namespace App\Repository\Spare;

use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    public function setOrderBy()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    }
}
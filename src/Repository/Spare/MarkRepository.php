<?php

namespace App\Repository\Spare;

use Doctrine\ORM\EntityRepository;

class MarkRepository extends EntityRepository
{
    public function setOrderBy()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    }
}
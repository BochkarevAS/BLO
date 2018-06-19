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

    public function spareAll()
    {
        return $this->createQueryBuilder('model')
            ->Join('model.mark', 'm')
            ->leftJoin('model.engines', 'e')
            ->leftJoin('model.spareParts', 's')
            ->addSelect('m.name')
            ->addSelect('e.id')
            ->getQuery()
            ->getResult();

//        var_dump($q->getSQL());die;
    }
}
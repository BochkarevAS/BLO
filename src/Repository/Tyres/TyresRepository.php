<?php

namespace App\Repository\Tyres;

use Doctrine\ORM\EntityRepository;

class TyresRepository extends EntityRepository
{
    public function renderTyre()
    {
        return $this->createQueryBuilder('t')
            ->join('t.manufacturers', 'm')
            ->getQuery()
            ->execute();
    }

}
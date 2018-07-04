<?php

namespace App\Repository\Tyres;

use App\Entity\Tyres\Picture;
use Doctrine\ORM\EntityRepository;

class TyresRepository extends EntityRepository
{
    public function renderTyre()
    {
        return $this->createQueryBuilder('t')
            ->select('p')
            ->join('t.manufacturers', 'm')
            ->join(Picture::class, 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p.tyres = t.id')
            ->getQuery()
            ->execute();
    }

}
<?php

namespace App\Repository\Parts;

use App\Entity\Parts\Oem;
use Doctrine\ORM\EntityRepository;

class OemRepository extends EntityRepository
{
    public function renderParts(Oem $oem)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->leftJoin('o.brand', 'b');




        return $qb->getQuery();
    }
}
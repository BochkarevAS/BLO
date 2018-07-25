<?php

namespace App\Repository\Parts;

use App\Entity\Parts\Part;
use Doctrine\ORM\EntityRepository;

class PartRepository extends EntityRepository
{
    public function renderParts(Part $part)
    {
        $qb = $this->createQueryBuilder('o');
//            ->select('o')
//            ->leftJoin('o.brand', 'b');


//        /* Фильтр по производителям */
//        if ($part->getBrand()) {
//            $qb->andWhere('b.id = :bid')->setParameter('bid', $part->getBrand()->getId());
//        }

        return $qb->getQuery();
    }
}
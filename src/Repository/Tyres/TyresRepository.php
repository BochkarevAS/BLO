<?php

namespace App\Repository\Tyres;

use App\Entity\Tyres\Picture;
use App\Entity\Tyres\Tyre;
use Doctrine\ORM\EntityRepository;

class TyresRepository extends EntityRepository
{
    public function search(Tyre $tyre)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('p')
            ->join('t.manufacturers', 'm')
            ->join(Picture::class, 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p.tyres = t.id');

        if ($tyre->getManufacturers()->getId()) {
            $qb->andWhere('m.id = :id')->setParameter('id', $tyre->getManufacturers()->getId());
        }

        if ($tyre->getVendors()) {
            $ids = [];

            foreach ($tyre->getVendors() as $vendor) {
                $ids[] = $vendor->getId();
            }

            $qb->leftJoin('t.vendors', 'v');
            $qb->andWhere('v.id IN (:ids)')->setParameter('ids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

//        if ($tyre->getThorns()->getId()) {
//            $qb->leftJoin('t.thorns', 'th');
//            $qb->andWhere('th.id = :id')->setParameter('id', $tyre->getThorns()->getId());
//        }

        return $qb->getQuery()->execute();
    }

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
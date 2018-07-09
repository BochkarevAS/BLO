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
            ->leftJoin(Picture::class, 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p.tyres = t.id');

        /* Фильтр по производителям */
        if ($tyre->getManufacturers()) {
            $qb->andWhere('m.id = :id')->setParameter('id', $tyre->getManufacturers()->getId());
        }

        /* Фильтр по шипам */
        if ($tyre->getThorns()) {
            $qb->leftJoin('t.thorns', 'th');
            $qb->andWhere('th.id = :id')->setParameter('id', $tyre->getThorns()->getId());
        }

        /* Фильтр по продавец */
        if (!$tyre->getVendors()->isEmpty()) {
            $ids = [];

            foreach ($tyre->getVendors() as $vendor) {
                $ids[] = $vendor->getId();
            }

            $qb->leftJoin('t.vendors', 'v');
            $qb->andWhere('v.id IN (:ids)')->setParameter('ids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

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
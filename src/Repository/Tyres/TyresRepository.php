<?php

namespace App\Repository\Tyres;

use App\Entity\Tyres\Picture;
use App\Entity\Tyres\Tyre;
use Doctrine\ORM\EntityRepository;

class TyresRepository extends EntityRepository
{
    public function renderTyres(Tyre $tyre)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('p')
//            ->join('t.manufacturers', 'm')
            ->leftJoin(Picture::class, 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p.tyres = t.id');

        /* Фильтр по производителям */
//        if ($tyre->getManufacturers()) {
//            $qb->andWhere('m.id = :mid')->setParameter('mid', $tyre->getManufacturers()->getId());
//        }

        /* Фильтр по шипам */
        if ($tyre->getThorns()) {
            $qb->join('t.thorns', 'th');
            $qb->andWhere('th.id = :thid')->setParameter('thid', $tyre->getThorns()->getId());
        }

        /* Фильтр по сезонам */
        if ($tyre->getSeasonalitys()) {
            $qb->leftJoin('t.seasonalitys', 's');
            $qb->andWhere('s.id = :sid')->setParameter('sid', $tyre->getSeasonalitys()->getId());
        }

        /* Фильтр по количеству шин */
        if ($tyre->getCounts()) {
            $qb->leftJoin('t.counts', 'c');
            $qb->andWhere('c.id = :cid')->setParameter('cid', $tyre->getCounts()->getId());
        }

        /* Фильтр по посадочный диаметр (мм) */
        if ($tyre->getDiameters()) {
            $qb->leftJoin('t.diameters', 'd');
            $qb->andWhere('d.id = :did')->setParameter('did', $tyre->getDiameters()->getId());
        }

        /* Фильтр по высота ширина (мм) */
        if ($tyre->getWidths()) {
            $qb->leftJoin('t.widths', 'w');
            $qb->andWhere('w.id = :wid')->setParameter('wid', $tyre->getWidths()->getId());
        }

        /* Фильтр по высота профиля (%) */
        if ($tyre->getHeights()) {
            $qb->leftJoin('t.heights', 'h');
            $qb->andWhere('h.id = :hid')->setParameter('hid', $tyre->getHeights()->getId());
        }

        /* Фильтр по продавец */
        if (!$tyre->getVendors()->isEmpty()) {
            $ids = [];

            foreach ($tyre->getVendors() as $vendor) {
                $ids[] = $vendor->getId();
            }

            $qb->leftJoin('t.vendors', 'v');
            $qb->andWhere('v.id IN (:vids)')->setParameter('vids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

        /* Фильтр по моделям */
//        if (!$tyre->getVendors()->isEmpty()) {
//            $ids = [];
//
//            foreach ($tyre->getVendors() as $vendor) {
//                $ids[] = $vendor->getId();
//            }
//
//            $qb->leftJoin('t.vendors', 'v');
//            $qb->andWhere('v.id IN (:vids)')->setParameter('vids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
//        }

        return $qb->getQuery();
    }
}
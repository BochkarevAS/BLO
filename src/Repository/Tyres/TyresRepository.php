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
            ->leftJoin('t.brands', 'b')
            ->leftJoin(Picture::class, 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p.tyres = t.id');

        /* Фильтр по производителям */
        if ($tyre->getBrands()) {
            $qb->andWhere('b.id = :bid')->setParameter('bid', $tyre->getBrands()->getId());
        }

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
        if ($tyre->getQuantity()) {
            $qb->andWhere('t.quantity = :quantity')->setParameter('quantity', $tyre->getQuantity());
        }

        /* Фильтр по посадочный диаметр (мм) */
        if ($tyre->getDiameter()) {
            $qb->andWhere('t.diameter = :diameter')->setParameter('diameter', $tyre->getDiameter());
        }

        /* Фильтр по высота ширина (мм) */
        if ($tyre->getWidth()) {
            $qb->andWhere('t.width = :width')->setParameter('width', $tyre->getWidth());
        }

        /* Фильтр по высота профиля (%) */
        if ($tyre->getHeight()) {
            $qb->andWhere('t.height = :height')->setParameter('height', $tyre->getHeight());
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
        if (!$tyre->getModels()->isEmpty()) {
            $ids = [];

            foreach ($tyre->getModels() as $model) {
                $ids[] = $model->getId();
            }

            $qb->leftJoin('t.models', 'm');
            $qb->andWhere('m.id IN (:mids)')->setParameter('mids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

        return $qb->getQuery();
    }
}
<?php

namespace App\Repository\Tyres;

use App\Entity\Tyres\Tyre;
use Doctrine\ORM\EntityRepository;

class TyresRepository extends EntityRepository
{
    public function search(Tyre $tyre)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t')
            ->leftJoin('t.brand', 'b');

        /* Фильтр по производителям */
        if ($tyre->getBrand()) {
            $qb->andWhere('b.id = :bid')->setParameter('bid', $tyre->getBrand()->getId());
        }

        /* Фильтр по шипам */
        if ($tyre->getThorn()) {
            $qb->join('t.thorn', 'th');
            $qb->andWhere('th.id = :thid')->setParameter('thid', $tyre->getThorn()->getId());
        }

        /* Фильтр по сезонам */
        if ($tyre->getSeasonality()) {
            $qb->leftJoin('t.seasonality', 's');
            $qb->andWhere('s.id = :sid')->setParameter('sid', $tyre->getSeasonality()->getId());
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
        if (!$tyre->getVendor()->isEmpty()) {
            $ids = [];

            foreach ($tyre->getVendor() as $vendor) {
                $ids[] = $vendor->getId();
            }

            $qb->leftJoin('t.vendor', 'v');
            $qb->andWhere('v.id IN (:vids)')->setParameter('vids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

        /* Фильтр по моделям */
        if (!$tyre->getModel()->isEmpty()) {
            $ids = [];

            foreach ($tyre->getModel() as $model) {
                $ids[] = $model->getId();
            }

            $qb->leftJoin('t.model', 'm');
            $qb->andWhere('m.id IN (:mids)')->setParameter('mids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
        }

        return $qb->getQuery();
    }
}
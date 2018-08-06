<?php

namespace App\Repository\Tyres;

use App\Entity\Tyres\Tyre;
use Doctrine\ORM\EntityRepository;

class TyresRepository extends EntityRepository
{
    public function search(Tyre $tyre)
    {
        $brand       = $tyre->getBrand();
        $models      = $tyre->getModels();
        $thorn       = $tyre->getThorn();
        $seasonality = $tyre->getSeasonality();
        $quantity    = $tyre->getQuantity();
        $diameter    = $tyre->getDiameter();
        $width       = $tyre->getWidth();
        $height      = $tyre->getHeight();
        $city        = $tyre->getCity();
        $company     = $tyre->getCompany();

        $qb = $this->createQueryBuilder('t')
            ->addSelect('b, m')
            ->leftJoin('t.brand', 'b')
            ->leftJoin('t.models', 'm')
            ->leftJoin('t.city', 'city')
            ->leftJoin('t.company', 'company');


        dump($tyre);

        /* Фильтр по производителям */
        if ($brand) {
            $qb->andWhere('b.id = :bid')->setParameter('bid', $brand->getId());
        }

        /* Фильтр по моделям */
        if (!$models->isEmpty()) {
            $ids = [];

            foreach ($models as $model) {
                $ids[] = $model->getId();
            }

            $qb->andWhere('m.id IN (:models)')->setParameter('models', $ids);
        }

        /* Фильтр по шипам */
        if ($thorn) {
            $qb->join('t.thorn', 'thorn');
            $qb->andWhere('th.id = :thornId')->setParameter('thornId', $thorn->getId());
        }

        /* Фильтр по сезонам */
        if ($seasonality) {
            $qb->leftJoin('t.seasonality', 's');
            $qb->andWhere('s.id = :seasonalityId')->setParameter('seasonalityId', $seasonality->getId());
        }

        /* Фильтр по количеству шин */
        if ($quantity) {
            $qb->andWhere('t.quantity = :quantity')->setParameter('quantity', $quantity);
        }

        /* Фильтр по посадочный диаметр (мм) */
        if ($diameter) {
            $qb->andWhere('t.diameter = :diameter')->setParameter('diameter', $diameter);
        }

        /* Фильтр по высота ширина (мм) */
        if ($width) {
            $qb->andWhere('t.width = :width')->setParameter('width', $width);
        }

        /* Фильтр по высота профиля (%) */
        if ($height) {
            $qb->andWhere('t.height = :height')->setParameter('height', $height);
        }

        /* Фильтр по городам */
        if ($city) {
            $qb->andWhere('city.id = :id')->setParameter('id', $city->getId());
        }

        /* Фильтр по компаниям */
        if ($company) {
            $qb->andWhere('company.id = :id')->setParameter('id', $company->getId());
        }

        return $qb->getQuery();
    }
}
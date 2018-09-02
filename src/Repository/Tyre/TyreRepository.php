<?php

namespace App\Repository\Tyre;

use App\Entity\Tyres\Tyre;
use Doctrine\ORM\EntityRepository;

class TyreRepository extends EntityRepository
{
    public function search(Tyre $tyre)
    {
        $brand        = $tyre->getBrand();
        $models       = $tyre->getModel();
        $thorn        = $tyre->getThorn();
        $seasonality  = $tyre->getSeasonality();
        $quantity     = $tyre->getQuantity();
        $diameter     = $tyre->getDiameter();
        $width        = $tyre->getWidth();
        $height       = $tyre->getHeight();
        $availability = $tyre->getAvailability();
        $condition    = $tyre->getCondition();
        $city         = $tyre->getCity();
        $company      = $tyre->getCompany();

        $qb = $this->createQueryBuilder('t')
            ->addSelect('b, m, s, a, c, th')
            ->leftJoin('t.brand', 'b')
            ->leftJoin('t.model', 'm')
            ->leftJoin('t.seasonality', 's')
            ->leftJoin('t.thorn', 'th')
            ->leftJoin('t.availability', 'a')
            ->leftJoin('t.condition', 'c')
            ->leftJoin('t.city', 'city')
            ->leftJoin('t.company', 'company');

        /* Фильтр по производителям */
        if ($brand) {
            $qb->andWhere('b.id = :bid')->setParameter('bid', $brand);
        }

        /* Фильтр по моделям */
        if (!$models->isEmpty()) {
            $qb->andWhere('m.id IN (:models)')->setParameter('models', $models);
        }

        /* Фильтр по шипам */
        if ($thorn) {
            $qb->andWhere('th.id = :thorn')->setParameter('thorn', $thorn);
        }

        /* Фильтр по сезонам */
        if ($seasonality) {
            $qb->andWhere('s.id = :seasonalityId')->setParameter('seasonalityId', $seasonality);
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

        /* Фильтр по состоянию */
        if ($availability) {
            $qb->andWhere('t.availability = :availability')->setParameter('availability', $availability);
        }

        /* Фильтр по наличию */
        if ($condition) {
            $qb->andWhere('t.condition = :condition')->setParameter('condition', $condition);
        }

        /* Фильтр по городам */
        if ($city) {
            $qb->andWhere('t.city = :city')->setParameter('city', $city);
        }

        /* Фильтр по компаниям */
        if ($company) {
            $qb->andWhere('t.company = :company')->setParameter('company', $company);
        }

        return $qb->getQuery();
    }
}
<?php

declare(strict_types=1);

namespace App\Repository\Tyre;

use App\Dto\TyreDto;
use Doctrine\ORM\EntityRepository;

class TyreRepository extends EntityRepository
{
    public function search(TyreDto $tyre)
    {
        $qb = $this->createQueryBuilder('t');

        if (null !== $tyre->brand) {
            $qb
                ->addSelect('b')
                ->leftJoin('t.brand', 'b')
                ->andWhere('t.brand = :brand')
                ->setParameter('brand', $tyre->brand);
        }

        if (false === $tyre->model->isEmpty()) {
            $qb
                ->addSelect('m')
                ->leftJoin('t.model', 'm')
                ->andWhere('t.model IN (:model)')
                ->setParameter('model', $tyre->model);
        }

        /**
         * Вот запрос:
         *
         * SELECT *
         * FROM tyre t
         * LEFT JOIN company c ON (c.id=t.company_id)
         * WHERE t.company_id=c.id
         *
         * Может быть его можно как то оптимищъзировать написать его лучше ???
         */
        if (null !== $tyre->company) {
            $qb
                ->addSelect('c')
                ->leftJoin('t.company', 'c')
                ->andWhere('t.company = :company')
                ->setParameter('company', $tyre->company);
        }

        if (null !== $tyre->user) {
            $qb
                ->addSelect('u')
                ->leftJoin('t.user', 'u')
                ->andWhere('t.user = :user')
                ->setParameter('user', $tyre->company);
        }

        if (null !== $tyre->city) {
            $qb
                ->addSelect('c')
                ->leftJoin('t.city', 'city')
                ->andWhere('t.city = :city')
                ->setParameter('city', $tyre->city);
        }

        if ('metric' == $tyre->metrics && null !== $tyre->diameter) {
            $qb->andWhere('t.diameter = :diameter')->setParameter('diameter', $tyre->diameter);
        }

        if ('metric' == $tyre->metrics && null !== $tyre->width) {
            $qb->andWhere('t.width = :width')->setParameter('width', $tyre->width);
        }

        if ('metric' == $tyre->metrics && null !== $tyre->height) {
            $qb->andWhere('t.height = :height')->setParameter('height', $tyre->height);
        }

        if ('inch' == $tyre->metrics && null !== $tyre->diameterIn) {
            $qb->andWhere('t.diameterIn = :diameterIn')->setParameter('diameterIn', $tyre->diameterIn);
        }

        if ('inch' == $tyre->metrics && null !== $tyre->widthIn) {
            $qb->andWhere('t.widthIn = :widthIn')->setParameter('widthIn', $tyre->widthIn);
        }

        if ('inch' == $tyre->metrics && null !== $tyre->heightIn) {
            $qb->andWhere('t.height = :heightIn')->setParameter('heightIn', $tyre->heightIn);
        }

        if (null !== $tyre->availability) {
            $qb->andWhere('t.availability = :availability')->setParameter('availability', $tyre->availability);
        }

        if (null !== $tyre->condition) {
            $qb->andWhere('t.condition = :condition')->setParameter('condition', $tyre->condition);
        }

        if (null !== $tyre->year) {
            $qb->andWhere('t.year = :year')->setParameter('year', $tyre->year);
        }

        if (null !== $tyre->quantity) {
            $qb->andWhere('t.quantity = :quantity')->setParameter('quantity', $tyre->quantity);
        }

        if (null !== $tyre->type) {
            $qb->andWhere('t.type = :type')->setParameter('type', $tyre->type);
        }

        if (null !== $tyre->protector) {
            $qb->andWhere('t.protector = :protector')->setParameter('protector', $tyre->protector);
        }

        if (0 < $tyre->priceFrom || 0 < $tyre->priceTo) {
            $qb
                ->andWhere('t.price >= :priceFrom AND t.price <= :priceTo')
                ->setParameters(['priceFrom' => $tyre->priceFrom, 'priceTo' => $tyre->priceTo]);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }
}
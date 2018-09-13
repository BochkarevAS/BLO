<?php

namespace App\Repository\Drive;

use App\Entity\Auth\User;
use App\Entity\Client\Favorite;
use App\Entity\Drives\Drive;
use Doctrine\ORM\EntityRepository;

class DriveRepository extends EntityRepository
{
    public function search(Drive $drive, User $user = null)
    {
        $brand        = $drive->getBrand();
        $models       = $drive->getModel();
        $diameter     = $drive->getDiameter();
        $width        = $drive->getWidth();
        $departure    = $drive->getDeparture();
        $drilling     = $drive->getDrilling();
        $availability = $drive->getAvailability();
        $condition    = $drive->getCondition();
        $city         = $drive->getCity();
        $company      = $drive->getCompany();
        $id           = 0;

        if ($user) {
            $id = $user->getId();
        }

        $qb = $this->createQueryBuilder('d')
            ->addSelect('b, m, a, c, city, company, f.id as favorite')
            ->leftJoin('d.brand', 'b')
            ->leftJoin('d.model', 'm')
            ->leftJoin('d.availability', 'a')
            ->leftJoin('d.condition', 'c')
            ->leftJoin('d.city', 'city')
            ->leftJoin('d.company', 'company')
            ->leftJoin(Favorite::class, 'f', \Doctrine\ORM\Query\Expr\Join::WITH, 'f.type=3 AND f.product=d.id AND f.user=' . $id);

        /* Фильтр по производителям */
        if ($brand) {
            $qb->andWhere('b.id = :bid')->setParameter('bid', $brand);
        }

        /* Фильтр по моделям */
        if (!$models->isEmpty()) {
            $qb->andWhere('m.id IN (:models)')->setParameter('models', $models);
        }

        /* Фильтр по состоянию */
        if ($availability) {
            $qb->andWhere('d.availability = :availability')->setParameter('availability', $availability);
        }

        /* Фильтр по наличию */
        if ($condition) {
            $qb->andWhere('d.condition = :condition')->setParameter('condition', $condition);
        }

        /* Фильтр по диаметр */
        if ($diameter) {
            $qb->andWhere('d.diameter = :diameter')->setParameter('diameter', $diameter);
        }

        /* Фильтр по ширине*/
        if ($width) {
            $qb->andWhere('d.width = :width')->setParameter('width', $width);
        }

        /* Фильтр по вылет*/
        if ($departure) {
            $qb->andWhere('d.departure = :departure')->setParameter('departure', $departure);
        }

        /* Фильтр по сверловки*/
        if ($drilling) {
            $qb->andWhere('d.drilling = :drilling')->setParameter('drilling', $drilling);
        }

        /* Фильтр по городам */
        if ($city) {
            $qb->andWhere('d.city = :city')->setParameter('city', $city);
        }

        /* Фильтр по компаниям */
        if ($company) {
            $qb->andWhere('d.company = :company')->setParameter('company', $company);
        }

        return $qb->getQuery();
    }
}
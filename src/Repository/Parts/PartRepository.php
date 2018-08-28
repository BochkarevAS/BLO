<?php

namespace App\Repository\Parts;

use App\Dto\Parts\SearchDTO;
use App\Entity\Parts\Part;
use Doctrine\ORM\EntityRepository;

class PartRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\Query
     */
    public function  search(Part $part, SearchDTO $searchDTO)
    {
        $brand        = $part->getBrand();
        $model        = $part->getModel();
        $carcase      = $part->getCarcase();
        $partName     = $part->getName();
        $city         = $part->getCity();
        $company      = $part->getCompany();
        $availability = $part->getAvailability();
        $condition    = $part->getCondition();
        $engine       = $searchDTO->getEngine();
        $oem          = $searchDTO->getOem();

        $qb = $this->createQueryBuilder('p')
            ->addSelect('b, m, a, cond, c, o, e')
            ->leftJoin('p.brand', 'b')
            ->leftJoin('p.model', 'm')
            ->leftJoin('p.carcase', 'c')
            ->leftJoin('p.oems', 'o')
            ->leftJoin('p.engines', 'e')
            ->leftJoin('p.availability', 'a')
            ->leftJoin('p.condition', 'cond')
            ->leftJoin('p.city', 'city')
            ->leftJoin('p.company', 'company');

        /* Фильтр по производителям */
        if ($brand) {
            $qb->andWhere('p.brand = :brand')->setParameter('brand', $brand);
        }

        /* Фильтр по моделям */
        if ($model) {
            $qb->andWhere('p.model = :model')->setParameter('model', $model);
        }

        /* Фильтр по кузовам */
        if ($carcase) {
            $qb->andWhere('p.carcase = :carcase')->setParameter('carcase', $carcase);
        }

        /* Фильтр по запчастям */
        if ($partName) {
            $qb->andWhere('p.name = :name')->setParameter('name', $partName);
        }

        /* Фильтр по оемам */
        if ($oem) {
            $qb->andWhere('p.oem = :oem')->setParameter('oem', $oem);
        }

        /* Фильтр по двигателям */
        if ($engine) {
            $qb->andWhere('p.engine = :engine')->setParameter('engine', $engine);
        }

        /* Фильтр по состоянию */
        if ($availability) {
            $qb->andWhere('p.availability = :availability')->setParameter('availability', $availability);
        }

        /* Фильтр по наличию */
        if ($condition) {
            $qb->andWhere('p.condition = :condition')->setParameter('condition', $condition);
        }

        /* Фильтр по городам */
        if ($city) {
            $qb->andWhere('p.city = :city')->setParameter('city', $city);
        }

         /* Фильтр по компаниям */
        if ($company) {
            $qb->andWhere('p.company = :company')->setParameter('company', $company);
        }

        return $qb->getQuery();
    }
}
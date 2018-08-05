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
        $brand     = $part->getBrand();
        $partName  = $part->getName();
        $city      = $part->getCity();
        $company   = $part->getCompany();
        $modelId   = $searchDTO->getModel();
        $carcaseId = $searchDTO->getCarcase();
        $engine    = $searchDTO->getEngine();
        $oem       = $searchDTO->getOem();

        $qb = $this->createQueryBuilder('p')
            ->addSelect('b, m, c, o')
            ->leftJoin('p.brand', 'b')
            ->leftJoin('p.models', 'm')
            ->leftJoin('p.carcases', 'c')
            ->leftJoin('p.oems', 'o')
            ->leftJoin('p.engines', 'e')
            ->leftJoin('p.city', 'city')
            ->leftJoin('p.company', 'company');

        /* Фильтр по производителям */
        if ($brand) {
            $qb->andWhere('b.id = :bid')->setParameter('bid', $brand->getId());
        }

        /* Фильтр по моделям */
        if ($modelId) {
            $qb->andWhere('m.id = :mid')->setParameter('mid', $modelId);
        }

        /* Фильтр по кузовам */
        if ($carcaseId) {
            $qb->andWhere('c.id = :cid')->setParameter('cid', $carcaseId);
        }

        /* Фильтр по запчастям */
        if ($partName) {
            $qb->andWhere('p.name = :name')->setParameter('name', $partName);
        }

        /* Фильтр по оемам */
        if ($oem) {
            $qb->andWhere('o.name = :name')->setParameter('name', $oem);
        }

        /* Фильтр по двигателям */
        if ($engine) {
            $qb->andWhere('e.name = :name')->setParameter('name', $engine);
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
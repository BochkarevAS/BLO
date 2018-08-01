<?php

namespace App\Repository\Parts;

use App\Dto\Parts\SearchDTO;
use App\Entity\Parts\Part;
use Doctrine\ORM\EntityRepository;

class PartRepository extends EntityRepository
{
    public function  search(Part $part, SearchDTO $searchDTO)
    {
        $brand = $part->getBrand();
        $partName = $part->getName();
        $modelId = $searchDTO->getModel();
        $carcaseId = $searchDTO->getCarcase();

        $qb = $this->createQueryBuilder('p');

        /* Фильтр по производителям */
        if ($brand) {
            $qb->join('p.brand', 'b')
                ->andWhere('b.id = :bid')
                ->setParameter('bid', $brand->getId());
        }

        /* Фильтр по моделям */
        if ($modelId) {
            $qb->join('p.models', 'm')
                ->andWhere('m.id = :mid')
                ->setParameter('mid', $modelId);
        }

        /* Фильтр по кузовам */
        if ($carcaseId) {
            $qb->join('p.carcases', 'c')
                ->andWhere('c.id = :cid')
                ->setParameter('cid', $carcaseId);
        }

        /* Фильтр по запчастям */
        if ($partName) {
            $qb->andWhere('p.name = :name')
                ->setParameter('name', $partName);
        }

//        /* Фильтр по кузовам */
//        if (array_key_exists('name', $part->getParts()) && $name = $part->getParts()['name']) {
//            $qb->join('p.carcases', 'n')
//                ->andWhere('c.id = :name')
//                ->setParameter('name', $name);
//        }


//        /* Фильтр по производителям */
//        if ($part->getBrand()) {
//            $qb->andWhere('b.id = :bid')->setParameter('bid', $part->getBrand()->getId());
//        }

        return $qb->getQuery();
    }
}
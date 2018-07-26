<?php

namespace App\Repository\Parts;

use App\Entity\Parts\Part;
use Doctrine\ORM\EntityRepository;

class PartRepository extends EntityRepository
{
    public function renderParts(Part $part)
    {
        $qb = $this->createQueryBuilder('p');
//            ->select('o')
//            ->leftJoin('o.brand', 'b');

        /* Фильтр по производителям */
        if (array_key_exists('brand', $part->getParts()) && $id = $part->getParts()['brand']) {
            $qb->join('p.brands', 'b')
                ->andWhere('b.id = :bid')
                ->setParameter('bid', $id);
        }

        /* Фильтр по моделям */
        if (array_key_exists('model', $part->getParts()) && $id = $part->getParts()['model']) {
            $qb->join('p.models', 'm')
                ->andWhere('m.id = :mid')
                ->setParameter('mid', $id);
        }

        /* Фильтр по кузовам */
        if (array_key_exists('carcase', $part->getParts()) && $id = $part->getParts()['carcase']) {
            $qb->join('p.carcases', 'c')
                ->andWhere('c.id = :cid')
                ->setParameter('cid', $id);
        }


//        /* Фильтр по производителям */
//        if ($part->getBrand()) {
//            $qb->andWhere('b.id = :bid')->setParameter('bid', $part->getBrand()->getId());
//        }

        return $qb->getQuery();
    }
}
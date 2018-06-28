<?php

namespace App\Repository\Parts;

use App\Entity\Parts\Part;
use Doctrine\ORM\EntityRepository;

class OemRepository extends EntityRepository
{
    public function search(Part $part)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->Join('o.parts', 'p');
        $qb->Join('p.carcases', 'c');
        $qb->Join('p.brands', 'b');
        $qb->Join('p.models', 'm');
        $qb->Join('p.engines', 'e');
//        $qb->andWhere('b.name LIKE :brand AND c.name LIKE :carcase AND e.name LIKE :model')
//            ->setParameter('brand', $part->getBrands()->getName())
//            ->setParameter('model', $part->getModels()->getName())
//            ->setParameter('carcase', $part->getCarcases()->getName());

        if ($part->getCity()) {
            $qb->andWhere('o.citys = :city')->setParameter('city', $part->getCity()->getId());
        }

        if ($part->getName()) {
            $qb->andWhere('p.name = :part')->setParameter('part', $part->getName());
        }

        if ($part->getOem()) {
            $qb->andWhere('o.name = :oem')->setParameter('oem', $part->getOem());
        }

        if ($part->getEngines()) {
            $qb->andWhere('e.name = :engine')->setParameter('engine', $part->getEngines());
        }

        return $qb->getQuery()->execute();
    }
}
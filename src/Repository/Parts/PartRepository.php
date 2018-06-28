<?php

namespace App\Repository\Parts;

use App\Entity\Parts\Part;
use App\Entity\Parts\PartEngineRelation;
use Doctrine\ORM\EntityRepository;

class PartRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC');
    }

    public function search(Part $part)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->Join('p.brands', 'b');
        $qb->Join('p.carcases', 'c');
        $qb->Join('p.oem', 'o');
//        $qb->Join('p.engines', 'e');
        $qb->andWhere('p.name LIKE :name')
            ->setParameter('name', $part->getName());

        return $qb->getQuery()->execute();

//        $query = $qb->getQuery();
//        var_dump($query->getSQL()); die;


//        $qb->Join('p.carcases', 'c');
//        $qb->Join(PartEngineRelation::class, 'r', 'WITH', 'r.parts=p.id');
//        $qb->andWhere('b.id = :brand AND m.id = :model AND c.id = :carcase')
//            ->setParameter('brand', $model->getBrand())
//            ->setParameter('model', $model->getName())
//            ->setParameter('carcase', $model->getCarcases());



//        if ($part->getEngines()) {
//            $qb->andWhere('e.name = :engine')->setParameter('engine', $part->getEngines());
//        }
//
//        if ($part->getParts()) {
//            $qb->andWhere('p.name = :part')->setParameter('part', $part->getParts());
//        }

//        if ($part->getCity()) {
//            $qb->andWhere('r.citys = :city')->setParameter('city', $part->getCity());
//        }

        return $qb->getQuery();

//        $query = $qb->getQuery();
//        var_dump($query->getSQL());die;
    }
}
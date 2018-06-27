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

    public function getBrandById($id)
    {
        $query = $this->createQueryBuilder('p')
            ->Join('p.brands', 'b')
            ->Join('p.models', 'm')
            ->addSelect('m.name')
            ->addSelect('p.id')
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
            //->execute();

        //        $query = $qb->getQuery();
        var_dump($query->getSQL());die;
    }

    public function search(Part $part)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->Join('m.brand', 'b');
        $qb->Join('m.engines', 'e');
        $qb->Join('m.parts', 'p');
        $qb->Join('m.carcases', 'c');
        $qb->Join(PartEngineRelation::class, 'r', 'WITH', 'r.parts=p.id');
        $qb->andWhere('b.id = :brand AND m.id = :model AND c.id = :carcase')
            ->setParameter('brand', $model->getBrand())
            ->setParameter('model', $model->getName())
            ->setParameter('carcase', $model->getCarcases());

        if ($model->getEngines()) {
            $qb->andWhere('e.name = :engine')->setParameter('engine', $model->getEngines());
        }

        if ($model->getParts()) {
            $qb->andWhere('p.name = :part')->setParameter('part', $model->getParts());
        }

        if ($model->getCity()) {
            $qb->andWhere('r.citys = :city')->setParameter('city', $model->getCity());
        }

        return $qb->getQuery();

//        $query = $qb->getQuery();
//        var_dump($query->getSQL());die;
    }
}
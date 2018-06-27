<?php

namespace App\Repository\Parts;

use App\Entity\Parts\Model;
use App\Entity\Parts\PartEngineRelation;
use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    public function orderBy()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    }

    public function search(Model $model)
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
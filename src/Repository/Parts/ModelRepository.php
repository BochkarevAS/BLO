<?php

namespace App\Repository\Parts;

use App\Entity\Parts\Model;
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
        $qb->Join('p.id', 'r');
        $qb->andWhere('b.id = :brand AND m.id = :model')
            ->setParameter('brand', $model->getBrand())
            ->setParameter('model', $model->getName());

        if ($model->getEngines()) {
            $qb->andWhere('e.name = :engine')->setParameter('engine', $model->getEngines());
        }

        if ($model->getParts()) {
            $qb->andWhere('p.name = :part')->setParameter('part', $model->getParts());
        }

        return $qb->getQuery();

//        var_dump($q->getSQL());die;
    }
}
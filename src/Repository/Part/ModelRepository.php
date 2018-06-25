<?php

namespace App\Repository\Part;

use App\Entity\Part\Model;
use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    public function setOrderBy()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    }

    public function getEngineByModel(int $id)
    {
        return $this->createQueryBuilder('m')
            ->join('m.engines', 'e')
            ->where('m.id = :model_id')
            ->setParameter('model_id', 1)
            ->getQuery()
            ->getResult();
    }

    public function search(Model $model)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->Join('m.brand', 'b');
        $qb->Join('m.engines', 'e');
        $qb->Join('m.parts', 's');
        $qb->andWhere('b.id = :brand AND m.id = :model')
            ->setParameter('brand', $model->getBrand())
            ->setParameter('model', $model->getName());

        if ($model->getEngines()) {
            $qb->andWhere('e.name = :engine')->setParameter('engine', $model->getEngines());
        }

        if ($model->getParts()) {
            $qb->andWhere('s.name = :part')->setParameter('part', $model->getParts());
        }

        return $qb->getQuery()->execute();

//        var_dump($q->getSQL());die;
    }
}
<?php

namespace App\Repository\Part;

use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    public function setOrderBy()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    }

    public function search(array $search = [])
    {
        return $this->createQueryBuilder('m')
            ->Join('m.brands', 'b')
            ->Join('m.engines', 'e')
            ->Join('m.parts', 's')
            ->andWhere('b.id = :brand AND 
                        m.id = :model AND 
                        e.name LIKE :engine AND
                        s.name LIKE :part')
            ->setParameters($search)
            ->addSelect('m.name')
            ->addSelect('e.id')
            ->getQuery()
            ->getResult();

//        var_dump($q->getSQL());die;
    }
}
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
//        $qb->Join('p.engines', 'e');
        $qb->andWhere('p.name LIKE :name')
            ->setParameter('name', $part->getName());

        return $qb->getQuery()->execute();
    }

}
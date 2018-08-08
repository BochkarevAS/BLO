<?php

namespace App\Repository\Client;

use Doctrine\ORM\EntityRepository;

class PriceRepository extends EntityRepository
{
    public function findAllPriceByCompany($start, $end)
    {
        return $this->createQueryBuilder('p')
            ->where('p.created_at BETWEEN :start AND :end')
            ->setParameter('start', $start->format('Y-m-d'))
            ->setParameter('end', $end->format('Y-m-d'))
            ->getQuery()
            ->getArrayResult();
    }
}
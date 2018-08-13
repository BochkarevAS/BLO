<?php

namespace App\Repository\Client;

use Doctrine\ORM\EntityRepository;

class PriceRepository extends EntityRepository
{
    public function findAllPricesByCompany(\DateTime $date)
    {
        $from = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $to   = new \DateTime($date->format("Y-m-d")." 23:59:59");

        return $this->createQueryBuilder('p')
            ->where('p.createdAt BETWEEN :from AND :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->getQuery()
            ->getArrayResult();
    }
}
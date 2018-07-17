<?php

namespace App\Repository\Client;

use App\Entity\Client\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function createCompanyQueryBuilder()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');
    }
}
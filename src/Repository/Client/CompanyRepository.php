<?php

namespace App\Repository\Client;

use App\Entity\Auth\User;
use App\Entity\Client\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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

    public function getCompanyByUserId(User $user)
    {
        if (!$user->getId()) {
            return null;
        }

        $qb = $this->createQueryBuilder('c')
            ->join('c.user', 'u')
            ->andWhere('c.user = :id')
            ->setParameter(':id', $user->getId());

        return $qb->getQuery()->execute();
    }

    public function orderBy()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');
    }
}
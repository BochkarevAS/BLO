<?php

namespace App\Repository\Client;

use App\Entity\Auth\User;
use App\Entity\Tyres\Tyre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAllPost(User $user)
    {
        return $this->createQueryBuilder('u')
            ->select('t')
            ->leftJoin(Tyre::class, 't', Join::WITH, 't.user = u.id')
            ->andWhere('u.id = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
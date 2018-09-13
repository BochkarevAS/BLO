<?php

namespace App\Repository\Client;

use App\Entity\Auth\User;
use App\Entity\Drives\Drive;
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

    public function findAllDeclaration(User $user)
    {
        $connection = $this->_em->getConnection();

        $query = $connection->prepare("
            SELECT p.id, 1 module, p.updated_at FROM part.part p WHERE p.user_id=:user_id
            UNION ALL
            SELECT t.id, 2 module, t.updated_at FROM tyre.tyre t WHERE t.user_id=:user_id
            UNION ALL
            SELECT d.id, 3 module, d.updated_at FROM drive.drive d WHERE d.user_id=:user_id
        ");
        $query->bindValue('user_id', $user->getId());
        $query->execute();

        return $query->fetchAll();
    }

    public function findAllTyre(User $user)
    {
        return $this->createQueryBuilder('u')
            ->select('t')
            ->leftJoin(Tyre::class, 't', Join::WITH, 't.user = u.id')
            ->andWhere('u.id = :user')
            ->setParameter('user', $user)
            ->getQuery();
    }

    public function findAllDrive(User $user)
    {
        return $this->createQueryBuilder('u')
            ->select('d')
            ->leftJoin(Drive::class, 'd', Join::WITH, 'd.user = u.id')
            ->andWhere('u.id = :user')
            ->setParameter('user', $user)
            ->getQuery();
    }
}
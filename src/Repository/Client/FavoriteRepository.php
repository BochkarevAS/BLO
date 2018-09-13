<?php

namespace App\Repository\Client;

use App\Entity\Auth\User;
use Doctrine\ORM\EntityRepository;

class FavoriteRepository extends EntityRepository
{
    public function findByProduct(User $user, $product, $type)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.user=:user AND f.product=:product AND f.type=:type')
            ->setParameters(['user' => $user, 'product' => $product, 'type' => $type])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
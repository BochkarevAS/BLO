<?php

namespace App\Repository\Client;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAllPost()
    {
        return $this->createQueryBuilder('u');
    }
}
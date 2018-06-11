<?php

namespace App\Repository\Client;

use Doctrine\ORM\EntityRepository;

class CompanyRepository extends EntityRepository
{
    public function createCompanyQueryBuilder()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');
    }
}
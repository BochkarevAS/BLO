<?php

namespace App\Repository\Drive;

use App\Entity\Drives\Drive;
use Doctrine\ORM\EntityRepository;

class DriveRepository extends EntityRepository
{
    public function search(Drive $drive)
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->getQuery();
    }
}
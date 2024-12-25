<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\LoyaltyCoupon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LoyaltyCouponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoyaltyCoupon::class);
    }

}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RelatedProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RelatedProductRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelatedProduct::class);
    }

}

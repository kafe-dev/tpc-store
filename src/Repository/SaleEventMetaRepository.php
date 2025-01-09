<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SaleEventMeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SaleEventMetaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaleEventMeta::class);
    }

    public function findMetaBySaleEventId(int $saleEventId): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.meta_key', 'm.meta_value')
            ->where('m.sale_event = :saleEventId')
            ->setParameter('saleEventId', $saleEventId)
            ->getQuery()
            ->getArrayResult();
    }

}

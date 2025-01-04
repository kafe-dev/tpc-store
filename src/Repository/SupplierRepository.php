<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Supplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SupplierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    public function findAllWithMetadata(): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.supplierMetas', 'm')
            ->addSelect('m')
            ->getQuery()
            ->getResult();
    }

    public function findByIdWithMetadata(int $id): ?Supplier
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.supplierMetas', 'm')
            ->addSelect('m')
            ->where('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function isNameUnique($name): bool
    {
        $count = $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getSingleScalarResult();
        return $count == 0;
    }
}

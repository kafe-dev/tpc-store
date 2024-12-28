<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function isSlugUnique($slug): bool
	{
        $count = $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleScalarResult();

        return $count == 0;
    }
	public function countChildren($parent): int
	{
		return $this->createQueryBuilder('e')
			->select('COUNT(e.id)')
			->where('e.parent = :parent')
			->setParameter('parent', $parent)
			->getQuery()
			->getSingleScalarResult();
	}
}

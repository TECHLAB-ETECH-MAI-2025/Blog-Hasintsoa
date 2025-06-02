<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Paginate Categories
     * @param int $start
     * @param int $length
     * @param string $search
     * @param array $columns
     * @param array $orders
     * @return Paginator<Category>
     */
    public function paginate(
        int $start,
        int $length,
        ?string $search,
        array $columns,
        ?array $orders
    ): Paginator {
        $qb = $this->createQueryBuilder('c');
        if ($search) {
            $qb->andWhere('c.title LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }
        $qb->orderBy(
            'c.' . $columns[$orders['column'] ?? 0],
            $orders['dir'] ?? 'desc'
        );
        return new Paginator(
            $qb->setFirstResult($start)
                ->setMaxResults($length)
                ->getQuery()
                ->setHint(Paginator::HINT_ENABLE_DISTINCT, false),
            false
        );
    }

    //    /**
    //     * @return Category[] Returns an array of Category objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Category
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

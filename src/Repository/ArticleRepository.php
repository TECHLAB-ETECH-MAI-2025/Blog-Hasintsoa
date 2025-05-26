<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private PaginatorInterface $paginator
    ) {
        parent::__construct($registry, Article::class);
    }

    /**
     * Pagination des articles
     * @param int $page
     * @param int $limit
     * @return PaginationInterface<int, mixed>
     */
    public function paginateArticles(int $page, int $limit): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder("a")
                ->orderBy("a.createdAt", "DESC"),
            $page,
            $limit,
            [
                "sortFieldAllowList" => [
                    "a.id",
                    "a.title",
                    "a.createdAt"
                ]
            ]
        );
    }

    /**
     * DataTable Listing
     * @param int $start
     * @param int $length
     * @param mixed $search
     * @param mixed $orderColumn
     * @param mixed $orderDir
     * @return array{data: mixed, filteredCount: bool|float|int|string|null, totalCount: bool|float|int|string|null}
     */
    public function findForDataTable($start, $length, $search, $orderColumn, $orderDir): array
    {
        $qb = $this->createQueryBuilder("a")
            ->addSelect('COUNT(com.id) AS commentsCount')
            ->addSelect('COUNT(l.id) as likesCount')
            ->addSelect('AVG(r.rating) as ratingsSum')
            ->leftJoin("a.categories", "c")
            ->leftJoin('a.comments', 'com')
            ->leftJoin('a.likes', 'l')
            ->leftJoin('a.ratings', 'r')
            ->groupBy("a.id", "c.title");
        if ($search) {
            $qb->andWhere('a.title LIKE :search OR c.title LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }
        $totalCount = $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->distinct()
            ->getQuery()
            ->getSingleScalarResult();
        $filteredCountQb = clone $qb;
        $filteredCount = $filteredCountQb
            ->select('COUNT(DISTINCT a.id)')
            ->distinct()
            ->getQuery()
            ->getScalarResult();
        if ($orderColumn === 'commentsCount') {
            $qb->orderBy('commentsCount', $orderDir);
        } elseif ($orderColumn === 'likesCount') {
            $qb->orderBy('likesCount', $orderDir);
        } elseif ($orderColumn === 'categories') {
            $qb->orderBy('c.title', $orderDir);
        } elseif ($orderColumn === 'ratingsSum') {
            $qb->orderBy("ratingsSum", $orderDir);
        } else {
            $qb->orderBy($orderColumn, $orderDir);
        }
        $qb->setFirstResult($start)
            ->setMaxResults($length);
        return [
            'data' => $qb->getQuery()->getResult(),
            'totalCount' => $totalCount,
            'filteredCount' => $filteredCount
        ];
    }
    /**
     * Paginate Articles for DataTable
     * This method is used to paginate articles for a DataTable with search and ordering capabilities.
     * @param int $start
     * @param int $length
     * @param array $search
     * @param array $columns
     * @param array $orders
     * @return Paginator<Article>
     */
    public function paginate(
        int $start,
        int $length,
        ?string $search,
        array $columns,
        ?array $orders
    ): Paginator {
        $qb = $this->createQueryBuilder('a')
            ->select('a.id', 'COUNT(l.id) as likesCount')
            ->leftJoin("a.categories", "c")
            ->leftJoin('a.likes', 'l')
            ->addSelect('c AS categoriesTitle')
            ->groupBy('a.id')
            ->orderBy('a.createdAt', 'DESC');

        if ($search) {
            $qb->andWhere('a.title LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        $qb->orderBy(
            $columns[$orders['column'] ?? 0],
            $orders['dir'] ?? 'desc'
        );

        return new Paginator(
            $qb->setFirstResult($start)
                ->setMaxResults($length)
        );
    }

    /**
     * Recherche par titre
     * @param string $query
     * @param int $limit
     * @return Article[] Retourne la liste des articles
     */
    public function searchByTitle(string $query, int $limit = 10): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.categories', 'c')
            ->where('a.title LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

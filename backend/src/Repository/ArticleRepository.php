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
     * DataTable Listing All Articles with rating Average and number of likes 
     * Get All Articles for the user if it's exist
     * @param int $start
     * @param int $length
     * @param string|null $search
     * @param string $orderColumn
     * @param string $orderDir
     * @return array{data: mixed, filteredCount: bool|float|int|string|null, totalCount: bool|float|int|string|null}
     */
    public function findForDataTable(
        int $start,
        int $length,
        ?string $search,
        string $orderColumn,
        string $orderDir,
        ?int $authorId
    ): array {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('COUNT(l.id) as likesCount')
            ->leftJoin("a.categories", "c")
            ->leftJoin('a.likes', 'l')
            ->groupBy('a.id', 'c.title');

        if ($search) {
            $qb = $qb->andWhere('a.title LIKE :search OR c.title LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        $totalCountQb = $this->createQueryBuilder('a')
            ->select('COUNT(a.id)');
        if ($authorId) {
            $qb = $qb->andWhere('a.author = :author')->setParameter('author', $authorId);
            $totalCountQb = $totalCountQb->andWhere('a.author = :author')->setParameter('author', $authorId);
        }
        $totalCount = $totalCountQb->distinct()
            ->getQuery()
            ->getSingleScalarResult();

        switch ($orderColumn) {
            case 'likesCount':
                $qb->orderBy('likesCount', $orderDir);
                break;
            case 'categories':
                $qb->orderBy('c.title', $orderDir);
                break;
            default:
                $qb->orderBy($orderColumn, $orderDir);
                break;
        }

        $qb->setFirstResult($start)
            ->setMaxResults($length);

        return [
            'data' => $qb->getQuery()->getResult(),
            'totalCount' => $totalCount
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

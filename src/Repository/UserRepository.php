<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }
        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Find user by email
     * @param string $email
     * @return User
     */
    public function findUserByEmail(string $email): User
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getSingleResult()
        ;
    }

    /**
     * Count all Admin Users
     * @return int
     */
    public function countAdmins(): int
    {
        $sql = 'SELECT COUNT(u.id) FROM "user" AS u WHERE CAST(u.roles AS TEXT) LIKE :role_admin OR CAST(u.roles AS TEXT) LIKE :role_super_admin';
        return (int) $this
            ->getEntityManager()
            ->getConnection()
            ->prepare($sql)
            ->executeQuery([
                "role_admin" => '%"ROLE_ADMIN"%',
                "role_super_admin" => '%"ROLE_SUPER_ADMIN"%',
            ])->fetchOne();
    }

    /**
     * Paginate Users
     * @param int $start
     * @param int $length
     * @param string $search
     * @param array $columns
     * @param array $orders
     * @return Paginator<User>
     */
    public function paginate(
        int $start,
        int $length,
        ?string $search,
        array $columns,
        ?array $orders
    ): Paginator {
        $qb = $this->createQueryBuilder('u');

        if ($search) {
            $qb->andWhere('u.email LIKE :search')
                ->orWhere('u.firstName LIKE :search')
                ->orWhere('u.lastName LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        $qb->orderBy(
            'u.' . $columns[$orders['column'] ?? 0],
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
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
}

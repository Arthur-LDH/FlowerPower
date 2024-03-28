<?php

namespace App\Repository\Orders;

use App\Entity\Orders\UsersOrders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersOrders>
 *
 * @method UsersOrders|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersOrders|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersOrders[]    findAll()
 * @method UsersOrders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersOrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersOrders::class);
    }

    //    /**
    //     * @return UsersOrders[] Returns an array of UsersOrders objects
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

    //    public function findOneBySomeField($value): ?UsersOrders
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

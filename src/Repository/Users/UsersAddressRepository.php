<?php

namespace App\Repository\Users;

use App\Entity\Users\UsersAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersAddress>
 *
 * @method UsersAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersAddress[]    findAll()
 * @method UsersAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersAddress::class);
    }

    //    /**
    //     * @return UsersAddress[] Returns an array of UsersAddress objects
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

    //    public function findOneBySomeField($value): ?UsersAddress
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

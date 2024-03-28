<?php

namespace App\Repository\Erp;

use App\Entity\Erp\CategoryErp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryErp>
 *
 * @method CategoryErp|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryErp|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryErp[]    findAll()
 * @method CategoryErp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryErpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryErp::class);
    }

    //    /**
    //     * @return CategoryErp[] Returns an array of CategoryErp objects
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

    //    public function findOneBySomeField($value): ?CategoryErp
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

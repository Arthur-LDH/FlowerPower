<?php

namespace App\Repository\Erp;

use App\Entity\Erp\ProductErp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductErp>
 *
 * @method ProductErp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductErp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductErp[]    findAll()
 * @method ProductErp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductErpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductErp::class);
    }

    //    /**
    //     * @return ProductErp[] Returns an array of ProductErp objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ProductErp
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository\Products;

use App\Entity\Products\CategoryErpProductSeller;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryErpProductSeller>
 *
 * @method CategoryErpProductSeller|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryErpProductSeller|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryErpProductSeller[]    findAll()
 * @method CategoryErpProductSeller[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryErpProductSellerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryErpProductSeller::class);
    }

    //    /**
    //     * @return CategoryErpProductSeller[] Returns an array of CategoryErpProductSeller objects
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

    //    public function findOneBySomeField($value): ?CategoryErpProductSeller
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

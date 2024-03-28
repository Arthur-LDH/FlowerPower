<?php

namespace App\Repository\Products;

use App\Entity\Products\ProductSeller;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductSeller>
 *
 * @method ProductSeller|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductSeller|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductSeller[]    findAll()
 * @method ProductSeller[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductSellerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductSeller::class);
    }

    //    /**
    //     * @return ProductSeller[] Returns an array of ProductSeller objects
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

    //    public function findOneBySomeField($value): ?ProductSeller
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

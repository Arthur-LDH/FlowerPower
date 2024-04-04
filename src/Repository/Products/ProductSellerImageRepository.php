<?php

namespace App\Repository\Products;

use App\Entity\Products\ProductSellerImage;
use App\Entity\Products\ProductSeller;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductSellerImage>
 *
 * @method ProductSellerImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductSellerImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductSellerImage[]    findAll()
 * @method ProductSellerImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductSellerImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductSellerImage::class);
    }

    //    /**
    //     * @return ProductSellerImage[] Returns an array of ProductSellerImage objects
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

    //    public function findOneBySomeField($value): ?ProductSellerImage
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

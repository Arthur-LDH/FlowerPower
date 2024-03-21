<?php

namespace App\Repository\Products;

use App\Entity\Products\ProductBaseImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductBaseImage>
 *
 * @method ProductBaseImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductBaseImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductBaseImage[]    findAll()
 * @method ProductBaseImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductBaseImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductBaseImage::class);
    }

    //    /**
    //     * @return ProductBaseImage[] Returns an array of ProductBaseImage objects
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

    //    public function findOneBySomeField($value): ?ProductBaseImage
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository\Promotions;

use App\Entity\Promotions\PromotionProductSellerOrErp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PromotionProductSellerOrErp>
 *
 * @method PromotionProductSellerOrErp|null find($id, $lockMode = null, $lockVersion = null)
 * @method PromotionProductSellerOrErp|null findOneBy(array $criteria, array $orderBy = null)
 * @method PromotionProductSellerOrErp[]    findAll()
 * @method PromotionProductSellerOrErp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionProductSellerOrErpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromotionProductSellerOrErp::class);
    }

    //    /**
    //     * @return PromotionProductSellerOrErp[] Returns an array of PromotionProductSellerOrErp objects
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

    //    public function findOneBySomeField($value): ?PromotionProductSellerOrErp
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

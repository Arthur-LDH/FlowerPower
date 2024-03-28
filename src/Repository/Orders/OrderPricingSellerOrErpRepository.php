<?php

namespace App\Repository\Orders;

use App\Entity\Orders\OrderPricingSellerOrErp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderPricingSellerOrErp>
 *
 * @method OrderPricingSellerOrErp|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderPricingSellerOrErp|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderPricingSellerOrErp[]    findAll()
 * @method OrderPricingSellerOrErp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderPricingSellerOrErpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderPricingSellerOrErp::class);
    }

    //    /**
    //     * @return OrderPricingSellerOrErp[] Returns an array of OrderPricingSellerOrErp objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OrderPricingSellerOrErp
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository\Products;

use App\Entity\Products\pricingSeller;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<pricingSeller>
 *
 * @method pricingSeller|null find($id, $lockMode = null, $lockVersion = null)
 * @method pricingSeller|null findOneBy(array $criteria, array $orderBy = null)
 * @method pricingSeller[]    findAll()
 * @method pricingSeller[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class pricingSellerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, pricingSeller::class);
    }

    //    /**
    //     * @return pricingSeller[] Returns an array of pricingSeller objects
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

    //    public function findOneBySomeField($value): ?pricingSeller
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

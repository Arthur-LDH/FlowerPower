<?php

namespace App\Repository\Erp;

use App\Entity\Erp\PricingErp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PricingErp>
 *
 * @method PricingErp|null find($id, $lockMode = null, $lockVersion = null)
 * @method PricingErp|null findOneBy(array $criteria, array $orderBy = null)
 * @method PricingErp[]    findAll()
 * @method PricingErp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricingErpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PricingErp::class);
    }

    //    /**
    //     * @return PricingErp[] Returns an array of PricingErp objects
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

    //    public function findOneBySomeField($value): ?PricingErp
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

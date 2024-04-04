<?php

namespace App\Repository\Promotions;

use App\Entity\Promotions\PromotionCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PromotionCategory>
 *
 * @method PromotionCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PromotionCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PromotionCategory[]    findAll()
 * @method PromotionCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromotionCategory::class);
    }

    //    /**
    //     * @return PromotionCategory[] Returns an array of PromotionCategory objects
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

    //    public function findOneBySomeField($value): ?PromotionCategory
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

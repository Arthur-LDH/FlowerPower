<?php

namespace App\Repository\Orders;

use App\Entity\Orders\Orders;
use App\Entity\Products\PricingSeller;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Orders>
 *
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }


    /**
     * @param Orders $order
     * @return float
     */
    public function calculateTotalOrder(Orders $order): float
    {

        $total = 0;

        foreach($order->getOrderPricingSellerOrErps() as $orderPricingSellerOrErp){
            $orderPricingSellerOrErp->setManagerRegistry($this->registry);
            $productTotal = $orderPricingSellerOrErp->getPricing()->getPrice() * $orderPricingSellerOrErp->getQuantity();

            if ($orderPricingSellerOrErp->getPricing() instanceof PricingSeller) {
                $product = $orderPricingSellerOrErp->getPricing()->getProductSeller();
            } else {
                $product = $orderPricingSellerOrErp->getPricing()->getProductErp();
            }
            $product->setManagerRegistry($this->registry);
            $promotions = $product->getPromotions();

            foreach ($promotions as $promotion) {
                if ($order->getCreatedAt() >= $promotion->getStartFrom() && $order->getCreatedAt() <= $promotion->getEndAt()) {
                    if ($promotion->isPercentage()) {
                        $productTotal = $productTotal * ($promotion->getDiscount() / 100);
                    } else {
                        $productTotal -= $promotion->getDiscount();
                    }
                }
            }

            $total += $productTotal;
        }



        return $total;
    }

}

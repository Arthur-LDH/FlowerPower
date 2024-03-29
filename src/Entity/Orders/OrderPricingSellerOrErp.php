<?php

namespace App\Entity\Orders;

use App\Entity\Erp\PricingErp;
use App\Entity\Products\PricingSeller;
use App\Repository\Orders\OrderPricingSellerOrErpRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderPricingSellerOrErpRepository::class)]
#[ORM\Table(name: 'orderPricingSellerOrErp', schema: 'db_orders')]
class OrderPricingSellerOrErp
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'orderPricingSellerOrErps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $orders = null;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $pricing = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getPricing(): null|PricingErp|PricingSeller
    {
        $entityManagerErp = ManagerRegistry::class->getManager('erp');
        $productErpRepository = $entityManagerErp->getRepository(PricingErp::class);
        $pricing = $productErpRepository->find($this->pricing);

        if ($pricing === null) {
            $entityManagerSeller = ManagerRegistry::class->getManager('seller');
            $productSellerRepository = $entityManagerSeller->getRepository(PricingSeller::class);
            $pricing = $productSellerRepository->find($this->pricing);
        }

        return $pricing;
    }

    public function setPricing(PricingSeller|PricingErp $pricing): static
    {
        $this->pricing = $pricing->getId();

        return $this;
    }
}

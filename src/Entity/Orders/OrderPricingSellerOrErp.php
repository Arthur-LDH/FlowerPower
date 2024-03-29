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

    private ?ManagerRegistry $managerRegistry = null;


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

    public function setManagerRegistry(ManagerRegistry $managerRegistry): static
    {
        $this->managerRegistry = $managerRegistry;

        return $this;
    }


    public function getPricing(): null|PricingErp|PricingSeller
    {
        if (!$this->managerRegistry) {
            throw new \RuntimeException('ManagerRegistry has not been set.');
        }

        $entityManagerErp = $this->managerRegistry->getManager('erp');
        $pricingErpRepository = $entityManagerErp->getRepository(PricingErp::class);
        $pricing = $pricingErpRepository->find($this->pricing);

        if ($pricing === null) {
            $entityManagerSeller = $this->managerRegistry->getManager('products');
            $pricingSellerRepository = $entityManagerSeller->getRepository(PricingSeller::class);
            $pricing = $pricingSellerRepository->find($this->pricing);
        }

        return $pricing;
    }

    public function setPricing(PricingSeller|PricingErp $pricing): static
    {
        $this->pricing = $pricing->getId();

        return $this;
    }
}

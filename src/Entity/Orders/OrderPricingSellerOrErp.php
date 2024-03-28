<?php

namespace App\Entity\Orders;

use App\Repository\Orders\OrderPricingSellerOrErpRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderPricingSellerOrErpRepository::class)]
#[ORM\Table(name: 'orderPricingSellerOrErp', schema: 'db_orders')]
class OrderPricingSellerOrErp
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}

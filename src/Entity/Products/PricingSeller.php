<?php

namespace App\Entity\Products;

use App\Entity\Orders\OrderPricingSellerOrErp;
use App\Repository\Products\pricingSellerRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: pricingSellerRepository::class)]
#[ORM\Table(name: 'pricingSeller', schema: 'db_products')]
#[ORM\HasLifecycleCallbacks]
class PricingSeller
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?float $tax = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column]
    private ?int $stock_left = null;

    #[ORM\Column]
    private ?int $stock_min = null;

    #[ORM\ManyToOne(inversedBy: 'pricingSellers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductSeller $productSeller = null;

    public function __construct()
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
    }

    /**
     * Gets triggered every time on update
     */
    #[ORM\PreUpdate]
    public function onPreUpdate(): static
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        return $this;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(float $tax): static
    {
        $this->tax = $tax;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getStockLeft(): ?int
    {
        return $this->stock_left;
    }

    public function setStockLeft(int $stock_left): static
    {
        $this->stock_left = $stock_left;

        return $this;
    }

    public function getStockMin(): ?int
    {
        return $this->stock_min;
    }

    public function setStockMin(int $stock_min): static
    {
        $this->stock_min = $stock_min;

        return $this;
    }

    public function getProductSeller(): ?ProductSeller
    {
        return $this->productSeller;
    }

    public function setProductSeller(?ProductSeller $productSeller): static
    {
        $this->productSeller = $productSeller;

        return $this;
    }
}

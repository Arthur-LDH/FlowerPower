<?php

namespace App\Entity\Promotions;

use App\Repository\Promotions\PromotionRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
#[ORM\Table(name: 'promotion', schema: 'db_promotions')]
#[ORM\HasLifecycleCallbacks]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $percentage = null;

    #[ORM\Column]
    private ?float $discount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_from = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_at = null;

    #[ORM\Column(length: 255)]
    private ?string $promo_code = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(targetEntity: PromotionProductSellerOrErp::class, mappedBy: 'promotion')]
    private Collection $promotionProductSellerOrErps;

    #[ORM\OneToMany(targetEntity: PromotionCategory::class, mappedBy: 'promotion')]
    private Collection $promotionCategories;

    public function __construct()
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
        $this->product = new ArrayCollection();
        $this->promotionProductSellerOrErps = new ArrayCollection();
        $this->promotionCategories = new ArrayCollection();
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

    public function isPercentage(): ?bool
    {
        return $this->percentage;
    }

    public function setPercentage(bool $percentage): static
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getStartFrom(): ?\DateTimeInterface
    {
        return $this->start_from;
    }

    public function setStartFrom(\DateTimeInterface $start_from): static
    {
        $this->start_from = $start_from;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->end_at;
    }

    public function setEndAt(\DateTimeInterface $end_at): static
    {
        $this->end_at = $end_at;

        return $this;
    }

    public function getPromoCode(): ?string
    {
        return $this->promo_code;
    }

    public function setPromoCode(string $promo_code): static
    {
        $this->promo_code = $promo_code;

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

    /**
     * @return Collection<int, PromotionProductSellerOrErp>
     */
    public function getPromotionProductSellerOrErps(): Collection
    {
        return $this->promotionProductSellerOrErps;
    }

    public function addPromotionProductSellerOrErp(PromotionProductSellerOrErp $promotionProductSellerOrErp): static
    {
        if (!$this->promotionProductSellerOrErps->contains($promotionProductSellerOrErp)) {
            $this->promotionProductSellerOrErps->add($promotionProductSellerOrErp);
            $promotionProductSellerOrErp->setPromotion($this);
        }

        return $this;
    }

    public function removePromotionProductSellerOrErp(PromotionProductSellerOrErp $promotionProductSellerOrErp): static
    {
        if ($this->promotionProductSellerOrErps->removeElement($promotionProductSellerOrErp)) {
            // set the owning side to null (unless already changed)
            if ($promotionProductSellerOrErp->getPromotion() === $this) {
                $promotionProductSellerOrErp->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PromotionCategory>
     */
    public function getPromotionCategories(): Collection
    {
        return $this->promotionCategories;
    }

    public function addPromotionCategory(PromotionCategory $promotionCategory): static
    {
        if (!$this->promotionCategories->contains($promotionCategory)) {
            $this->promotionCategories->add($promotionCategory);
            $promotionCategory->setPromotion($this);
        }

        return $this;
    }

    public function removePromotionCategory(PromotionCategory $promotionCategory): static
    {
        if ($this->promotionCategories->removeElement($promotionCategory)) {
            // set the owning side to null (unless already changed)
            if ($promotionCategory->getPromotion() === $this) {
                $promotionCategory->setPromotion(null);
            }
        }

        return $this;
    }
}

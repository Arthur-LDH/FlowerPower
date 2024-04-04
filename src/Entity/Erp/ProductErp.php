<?php

namespace App\Entity\Erp;

use App\Entity\Promotions\PromotionProductSellerOrErp;
use App\Repository\Erp\ProductErpRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductErpRepository::class)]
#[ORM\Table(name: 'productErp', schema: 'db_erp')]
#[ORM\HasLifecycleCallbacks]
class ProductErp
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $seasonality_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $seasonality_end = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(targetEntity: PricingErp::class, mappedBy: 'productErp', orphanRemoval: true)]
    private Collection $pricingErps;

    #[ORM\ManyToMany(targetEntity: CategoryErp::class, inversedBy: 'productErps')]
    private Collection $categoryErp;

    private ?ManagerRegistry $managerRegistry = null;


    public function __construct()
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
        $this->pricingErps = new ArrayCollection();
        $this->categoryErp = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSeasonalityStart(): ?\DateTimeInterface
    {
        return $this->seasonality_start;
    }

    public function setSeasonalityStart(\DateTimeInterface $seasonality_start): static
    {
        $this->seasonality_start = $seasonality_start;

        return $this;
    }

    public function getSeasonalityEnd(): ?\DateTimeInterface
    {
        return $this->seasonality_end;
    }

    public function setSeasonalityEnd(\DateTimeInterface $seasonality_end): static
    {
        $this->seasonality_end = $seasonality_end;

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

    public function setUpdatedAt(\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getPromotions(): ?ArrayCollection
    {
        if (!$this->managerRegistry) {
            throw new \RuntimeException('ManagerRegistry has not been set.');
        }

        $promotions = new ArrayCollection();
        $entityManager = $this->managerRegistry->getManager('promotions');
        $promotionProductSellerOrErpErpRepository = $entityManager->getRepository(PromotionProductSellerOrErp::class);
        foreach($promotionProductSellerOrErpErpRepository->findBy(['product' => $this->id]) as $relation)
        {
            if ($relation instanceof PromotionProductSellerOrErp) {
                $promotions->add($relation->getPromotion());
            }
        }

        return $promotions;
    }

    /**
     * @return Collection<int, PricingErp>
     */
    public function getPricingErps(): Collection
    {
        return $this->pricingErps;
    }

    public function addPricingErp(PricingErp $pricingErp): static
    {
        if (!$this->pricingErps->contains($pricingErp)) {
            $this->pricingErps->add($pricingErp);
            $pricingErp->setProductErp($this);
        }

        return $this;
    }

    public function removePricingErp(PricingErp $pricingErp): static
    {
        if ($this->pricingErps->removeElement($pricingErp)) {
            // set the owning side to null (unless already changed)
            if ($pricingErp->getProductErp() === $this) {
                $pricingErp->setProductErp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategoryErp>
     */
    public function getCategoryErp(): Collection
    {
        return $this->categoryErp;
    }

    public function addCategoryErp(CategoryErp $categoryErp): static
    {
        if (!$this->categoryErp->contains($categoryErp)) {
            $this->categoryErp->add($categoryErp);
        }

        return $this;
    }

    public function removeCategoryErp(CategoryErp $categoryErp): static
    {
        $this->categoryErp->removeElement($categoryErp);

        return $this;
    }

    public function setManagerRegistry(ManagerRegistry $managerRegistry): static
    {
        $this->managerRegistry = $managerRegistry;

        return $this;
    }
}

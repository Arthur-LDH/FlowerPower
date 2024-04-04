<?php

namespace App\Entity\Products;

use App\Entity\Promotions\PromotionProductSellerOrErp;
use App\Entity\Reviews\Review;
use App\Entity\Users\Seller;
use App\Entity\Users\Users;
use App\Repository\Products\ProductSellerRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductSellerRepository::class)]
#[ORM\Table(name: 'productSeller', schema: 'db_products')]
#[ORM\HasLifecycleCallbacks]
class ProductSeller
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(targetEntity: ProductSellerImage::class, mappedBy: 'products')]
    private Collection $productSellerImages;

    #[ORM\OneToMany(targetEntity: PricingSeller::class, mappedBy: 'productSeller', orphanRemoval: true)]
    private Collection $pricingSellers;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $seller = null;

    #[ORM\OneToMany(targetEntity: CategoryErpProductSeller::class, mappedBy: 'productSeller')]
    private Collection $categoryErpProductSeller;

    private ?ManagerRegistry $managerRegistry = null;


    public function __construct()
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
        $this->productSellerImages = new ArrayCollection();
        $this->pricingSellers = new ArrayCollection();
        $this->categoryErpProductSeller = new ArrayCollection();
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

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, ProductSellerImage>
     */
    public function getProductSellerImages(): Collection
    {
        return $this->productSellerImages;
    }

    public function addProductSellerImage(ProductSellerImage $productSellerImage): static
    {
        if (!$this->productSellerImages->contains($productSellerImage)) {
            $this->productSellerImages->add($productSellerImage);
            $productSellerImage->setProducts($this);
        }

        return $this;
    }

    public function removeProductSellerImage(ProductSellerImage $productSellerImage): static
    {
        if ($this->productSellerImages->removeElement($productSellerImage)) {
            // set the owning side to null (unless already changed)
            if ($productSellerImage->getProducts() === $this) {
                $productSellerImage->setProducts(null);
            }
        }

        return $this;
    }

    public function getReviews(): array
    {
        if (!$this->managerRegistry) {
            throw new \RuntimeException('ManagerRegistry has not been set.');
        }

        $entityManager = $this->managerRegistry->getManager('reviews');
        $reviewRepository = $entityManager->getRepository(Review::class);
        return $reviewRepository->findBy(['user' => $this->id]);
    }

    /**
     * @return Collection<int, PricingSeller>
     */
    public function getPricingSellers(): Collection
    {
        return $this->pricingSellers;
    }

    public function addPricingSeller(PricingSeller $pricingSeller): static
    {
        if (!$this->pricingSellers->contains($pricingSeller)) {
            $this->pricingSellers->add($pricingSeller);
            $pricingSeller->setProductSeller($this);
        }

        return $this;
    }

    public function removePricingSeller(PricingSeller $pricingSeller): static
    {
        if ($this->pricingSellers->removeElement($pricingSeller)) {
            // set the owning side to null (unless already changed)
            if ($pricingSeller->getProductSeller() === $this) {
                $pricingSeller->setProductSeller(null);
            }
        }

        return $this;
    }

    public function getSeller(): ?Seller
    {
        if (!$this->managerRegistry) {
            throw new \RuntimeException('ManagerRegistry has not been set.');
        }

        $entityManager = $this->managerRegistry->getManager('default');
        $sellerRepository = $entityManager->getRepository(Seller::class);
        return $sellerRepository->find($this->seller);
    }

    public function setSeller(Seller $seller): static
    {
        $this->seller = $seller->getId();

        return $this;
    }

    /**
     * @return Collection<int, CategoryErpProductSeller>
     */
    public function getCategoryErpProductSeller(): Collection
    {
        return $this->categoryErpProductSeller;
    }

    public function addCategoryErpProductSeller(CategoryErpProductSeller $categoryErpProductSeller): static
    {
        if (!$this->categoryErpProductSeller->contains($categoryErpProductSeller)) {
            $this->categoryErpProductSeller->add($categoryErpProductSeller);
            $categoryErpProductSeller->setProductSeller($this);
        }

        return $this;
    }

    public function removeCategoryErpProductSeller(CategoryErpProductSeller $categoryErpProductSeller): static
    {
        if ($this->categoryErpProductSeller->removeElement($categoryErpProductSeller)) {
            // set the owning side to null (unless already changed)
            if ($categoryErpProductSeller->getProductSeller() === $this) {
                $categoryErpProductSeller->setProductSeller(null);
            }
        }

        return $this;
    }

    public function setManagerRegistry(ManagerRegistry $managerRegistry): static
    {
        $this->managerRegistry = $managerRegistry;

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

    public function getCategories(): ?ArrayCollection
    {
        $categories = new ArrayCollection();
        foreach($this->getCategoryErpProductSeller() as $relation)
        {
            $categories->add($relation->getCategoryErp());
        }

        return $categories;
    }
}

<?php

namespace App\Entity\Erp;

use App\Entity\Products\CategoryErpProductSeller;
use App\Entity\Promotions\PromotionCategory;
use App\Repository\Erp\CategoryErpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CategoryErpRepository::class)]
#[ORM\Table(name: 'categoryErp', schema: 'db_erp')]
class CategoryErp
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: ProductErp::class, mappedBy: 'categoryErp')]
    private Collection $productErps;

    public function __construct()
    {
        $this->productErps = new ArrayCollection();
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

    public function getPromotions(): ArrayCollection
    {
        $promotions = new ArrayCollection();
        $entityManager = ManagerRegistry::class->getManager('promotions');
        $promotionCategoryRepository = $entityManager->getRepository(PromotionCategory::class);
        foreach($promotionCategoryRepository->findBy(['categoryErp' => $this->id]) as $relation)
        {
            $promotions->add($relation->getPromotion);
        }

        return $promotions;
    }

    /**
     * @return Collection<int, ProductErp>
     */
    public function getProductErps(): Collection
    {
        return $this->productErps;
    }

    public function addProductErp(ProductErp $productErp): static
    {
        if (!$this->productErps->contains($productErp)) {
            $this->productErps->add($productErp);
            $productErp->addCategoryErp($this);
        }

        return $this;
    }

    public function removeProductErp(ProductErp $productErp): static
    {
        if ($this->productErps->removeElement($productErp)) {
            $productErp->removeCategoryErp($this);
        }

        return $this;
    }

    public function getProductSellers(): ArrayCollection
    {
        $productSellers = new ArrayCollection();
        $entityManager = ManagerRegistry::class->getManager('products');
        $categoryErpProductSeller = $entityManager->getRepository(CategoryErpProductSeller::class);
        foreach($categoryErpProductSeller->findBy(['categoryErp' => $this->id]) as $relation)
        {
            $productSellers->add($relation->getProductSeller);
        }

        return $productSellers;
    }
}

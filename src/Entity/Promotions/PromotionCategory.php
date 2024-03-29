<?php

namespace App\Entity\Promotions;

use App\Entity\Erp\CategoryErp;
use App\Repository\Promotions\PromotionCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PromotionCategoryRepository::class)]
class PromotionCategory
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'promotionCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Promotion $promotion = null;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $categoryErp = null;

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getCategoryErp(): ?CategoryErp
    {
        $entityManager = ManagerRegistry::class->getManager('erp');
        $categoryErpRepository = $entityManager->getRepository(CategoryErp::class);
        return $categoryErpRepository->find($this->categoryErp);
    }

    public function setCategoryErp(CategoryErp $categoryErp): static
    {
        $this->categoryErp = $categoryErp->getId();

        return $this;
    }
}

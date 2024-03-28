<?php

namespace App\Entity\Promotions;

use App\Entity\Erp\ProductErp;
use App\Entity\Products\ProductSeller;
use App\Repository\Promotions\PromotionProductSellerOrErpRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PromotionProductSellerOrErpRepository::class)]
class PromotionProductSellerOrErp
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'promotionProductSellerOrErps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Promotion $promotion = null;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $product = null;

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getProduct(): null|ProductErp|ProductSeller
    {
        $entityManagerErp = ManagerRegistry::class->getManager('erp');
        $productErpRepository = $entityManagerErp->getRepository(ProductErp::class);
        $product = $productErpRepository->find($this->product);

        if ($product === null) {
            $entityManagerSeller = ManagerRegistry::class->getManager('seller');
            $productSellerRepository = $entityManagerSeller->getRepository(ProductSeller::class);
            $product = $productSellerRepository->find($this->product);
        }

        return $product;
    }

    public function setProduct(Uuid $product): static
    {
        $this->product = $product;

        return $this;
    }
}

<?php

namespace App\Entity\Products;

use App\Entity\Erp\CategoryErp;
use App\Repository\Products\CategoryErpProductSellerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CategoryErpProductSellerRepository::class)]
class CategoryErpProductSeller
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'categoryErp')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductSeller $productSeller = null;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $categoryErp = null;

    private ?ManagerRegistry $managerRegistry = null;

    public function getProductSeller(): ?ProductSeller
    {
        return $this->productSeller;
    }

    public function setProductSeller(?ProductSeller $productSeller): static
    {
        $this->productSeller = $productSeller;

        return $this;
    }

    public function getCategoryErp(): ?CategoryErp
    {
        if (!$this->managerRegistry) {
            throw new \RuntimeException('ManagerRegistry has not been set.');
        }

        $entityManager = $this->managerRegistry->getManager('erp');
        $categoryErpRepository = $entityManager->getRepository(CategoryErp::class);
        return $categoryErpRepository->find($this->categoryErp);
    }

    public function setCategoryErp(CategoryErp $categoryErp): static
    {
        $this->categoryErp = $categoryErp->getId();

        return $this;
    }

    public function setManagerRegistry(ManagerRegistry $managerRegistry): static
    {
        $this->managerRegistry = $managerRegistry;

        return $this;
    }
}

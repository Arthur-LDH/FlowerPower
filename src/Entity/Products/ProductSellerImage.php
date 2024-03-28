<?php

namespace App\Entity\Products;

use App\Repository\Products\ProductSellerImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductSellerImageRepository::class)]
#[ORM\Table(name: 'productSellerImage', schema: 'db_products')]
class ProductSellerImage
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'productSellerImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductSeller $products = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'productSellerImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $images = null;

    #[ORM\Column]
    private ?bool $front = null;

    public function getProducts(): ?ProductSeller
    {
        return $this->products;
    }

    public function setProducts(?ProductSeller $products): static
    {
        $this->products = $products;

        return $this;
    }

    public function getImages(): ?Image
    {
        return $this->images;
    }

    public function setImages(?Image $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function isFront(): ?bool
    {
        return $this->front;
    }

    public function setFront(bool $front): static
    {
        $this->front = $front;

        return $this;
    }
}

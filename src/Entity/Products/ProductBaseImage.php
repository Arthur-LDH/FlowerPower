<?php

namespace App\Entity\Products;

use App\Repository\Products\ProductBaseImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductBaseImageRepository::class)]
#[ORM\Table(name: 'productBaseImage', schema: 'db_products')]
class ProductBaseImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column]
    private ?bool $front = null;

    public function getId(): ?Uuid
    {
        return $this->id;
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

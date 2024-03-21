<?php

namespace App\Entity\Users;

use App\Repository\Users\UsersAddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UsersAddressRepository::class)]
#[ORM\Table(name: 'usersAddress', schema: 'db_users')]
class UsersAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column]
    private ?bool $facturation = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function isFacturation(): ?bool
    {
        return $this->facturation;
    }

    public function setFacturation(bool $facturation): static
    {
        $this->facturation = $facturation;

        return $this;
    }
}

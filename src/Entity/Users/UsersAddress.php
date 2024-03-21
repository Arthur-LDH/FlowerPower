<?php

namespace App\Entity\Users;

use App\Repository\Users\UsersAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersAddressRepository::class)]
#[ORM\Table(name: 'usersAddress', schema: 'db-users')]

class UsersAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column]
    private ?bool $facturation = null;

    public function getId(): ?int
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

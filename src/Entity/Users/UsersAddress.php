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
    #[ORM\ManyToOne(inversedBy: 'usersAddresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'usersAddresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $address = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column]
    private ?bool $facturation = null;

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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }
}

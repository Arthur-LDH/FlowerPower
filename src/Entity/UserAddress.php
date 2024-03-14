<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'user_address')]
class UserAddress
{
    //TODO : vérifier la relation
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_uid', referencedColumnName: 'uid')]
    private ?User $user = null;

    //TODO : vérifier la relation
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Address::class)]
    #[ORM\JoinColumn(name: 'address_uid', referencedColumnName: 'uid')]
    private ?Address $address = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $label = null;

    #[ORM\Column(type: 'boolean')]
    private bool $facturation = false;

    // Getters and setters for each property...

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): void
    {
        $this->address = $address;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function isFacturation(): bool
    {
        return $this->facturation;
    }

    public function setFacturation(bool $facturation): void
    {
        $this->facturation = $facturation;
    }
}

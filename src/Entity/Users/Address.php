<?php

namespace App\Entity\Users;

use App\Repository\Users\AddressRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\Table(name: 'address', schema: 'db_users')]
#[ORM\HasLifecycleCallbacks]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\OneToMany(targetEntity: UsersAddress::class, mappedBy: 'address', orphanRemoval: true)]
    private Collection $usersAddresses;

    #[ORM\OneToMany(targetEntity: Seller::class, mappedBy: 'address')]
    private Collection $sellers;

    public function __construct()
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
        $this->usersAddresses = new ArrayCollection();
        $this->sellers = new ArrayCollection();
    }

    /**
     * Gets triggered every time on update
     */
    #[ORM\PreUpdate]
    public function onPreUpdate(): static
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        return $this;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return Collection<int, UsersAddress>
     */
    public function getUsersAddresses(): Collection
    {
        return $this->usersAddresses;
    }

    public function addUsersAddress(UsersAddress $usersAddress): static
    {
        if (!$this->usersAddresses->contains($usersAddress)) {
            $this->usersAddresses->add($usersAddress);
            $usersAddress->setAddress($this);
        }

        return $this;
    }

    public function removeUsersAddress(UsersAddress $usersAddress): static
    {
        if ($this->usersAddresses->removeElement($usersAddress)) {
            // set the owning side to null (unless already changed)
            if ($usersAddress->getAddress() === $this) {
                $usersAddress->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Seller>
     */
    public function getSellers(): Collection
    {
        return $this->sellers;
    }

    public function addSeller(Seller $seller): static
    {
        if (!$this->sellers->contains($seller)) {
            $this->sellers->add($seller);
            $seller->setAddress($this);
        }

        return $this;
    }

    public function removeSeller(Seller $seller): static
    {
        if ($this->sellers->removeElement($seller)) {
            // set the owning side to null (unless already changed)
            if ($seller->getAddress() === $this) {
                $seller->setAddress(null);
            }
        }

        return $this;
    }
}

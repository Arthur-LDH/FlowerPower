<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'seller')]
#[ORM\HasLifecycleCallbacks]
class Seller
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?UuidInterface $uid = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length:50, nullable : false)]
    private ?string $national_code = null;

    #[ORM\Column (length:100, nullable :false)]
    private ?string $company_name = null;

    #[ORM\Column (length: 100, nullable : false)]
    private ?string $seller_name = null;

    #[ORM\Column (length:100, nullable : false)]
    private ?string $phone = null;

    #[ORM\OneToMany(targetEntity: Address::class, mappedBy:"sellers")]
    #[ORM\JoinColumn(name: 'address_uid', referencedColumnName: 'uid')]
    private ?Address $address_uid = null ;

    #[ORM\ManyToOne(targetEntity:User::class, inversedBy:"sellers")]
    #[ORM\JoinColumn(nullable:false)]
    private ?User $user = null;

    #[ORM\Column(nullable:false)]
    private ?DateTime $created_at = null;


    #[ORM\Column(nullable:true)]
    private ?DateTime $updated_at = null;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }
    #[ORM\PreUpdate]
    public function onPreUpdate(): static
    {
        $this->setUpdatedAt(new DateTime());
        return $this;
    }

    public function getUid(): ?UuidInterface
    {
        return $this->uid;
    }

    public function setUid(?UuidInterface $uid): void
    {
        $this->uid = $uid;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getNationalCode(): ?string
    {
        return $this->national_code;
    }

    public function setNationalCode(?string $national_code): void
    {
        $this->national_code = $national_code;
    }

    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    public function setCompanyName(?string $company_name): void
    {
        $this->company_name = $company_name;
    }

    public function getSellerName(): ?string
    {
        return $this->seller_name;
    }

    public function setSellerName(?string $seller_name): void
    {
        $this->seller_name = $seller_name;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getAddressUid(): ?Address
    {
        return $this->address_uid;
    }

    public function setAddressUid(?Address $address_uid): void
    {
        $this->address_uid = $address_uid;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }


}

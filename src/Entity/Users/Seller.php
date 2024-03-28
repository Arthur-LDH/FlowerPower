<?php

namespace App\Entity\Users;

use App\Entity\Erp\InvoiceErp;
use App\Entity\Products\ProductSeller;
use App\Repository\Users\SellerRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SellerRepository::class)]
#[ORM\Table(name: 'seller', schema: 'db_users')]
class Seller
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 50)]
    private ?string $national_code = null;

    #[ORM\Column(length: 100)]
    private ?string $company_name = null;

    #[ORM\Column(length: 100)]
    private ?string $seller_name = null;

    #[ORM\Column(length: 15)]
    private ?string $phone = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'sellers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    #[ORM\ManyToOne(inversedBy: 'sellers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $address = null;

    public function __construct()
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
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

    public function getNationalCode(): ?string
    {
        return $this->national_code;
    }

    public function setNationalCode(string $national_code): static
    {
        $this->national_code = $national_code;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    public function setCompanyName(string $company_name): static
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function getSellerName(): ?string
    {
        return $this->seller_name;
    }

    public function setSellerName(string $seller_name): static
    {
        $this->seller_name = $seller_name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
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

    public function getProducts(): ArrayCollection
    {
        $entityManager = ManagerRegistry::class->getManager('products');
        $productsSellerRepository = $entityManager->getRepository(ProductSeller::class);
        return $productsSellerRepository->findBy(['seller' => $this->id]);
    }

    public function getInvoices(): ArrayCollection
    {
        $entityManager = ManagerRegistry::class->getManager('erp');
        $invoiceErpRepository = $entityManager->getRepository(InvoiceErp::class);
        return $invoiceErpRepository->findBy(['seller' => $this->id]);
    }
}

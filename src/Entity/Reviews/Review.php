<?php

namespace App\Entity\Reviews;

use App\Entity\Erp\ProductErp;
use App\Entity\Products\ProductSeller;
use App\Entity\Users\Users;
use App\Repository\Reviews\ReviewRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\Table(name: 'review', schema: 'db_reviews')]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?float $note = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $product = null;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $users = null;

    private ?ManagerRegistry $managerRegistry = null;

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


    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): static
    {
        $this->note = $note;

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

    public function getProduct(): null|ProductErp|ProductSeller
    {
        if (!$this->managerRegistry) {
            throw new \RuntimeException('ManagerRegistry has not been set.');
        }

        $entityManagerErp = $this->managerRegistry->getManager('erp');
        $productErpRepository = $entityManagerErp->getRepository(ProductErp::class);
        $product = $productErpRepository->find($this->product);

        if ($product === null) {
            $entityManagerSeller = $this->managerRegistry->getManager('seller');
            $productSellerRepository = $entityManagerSeller->getRepository(ProductSeller::class);
            $product = $productSellerRepository->find($this->product);
        }

        return $product;
    }

    public function setProduct(ProductErp|ProductSeller $product): static
    {
        $this->product = $product->getId();

        return $this;
    }

    public function getUser(): ?Users
    {
        if (!$this->managerRegistry) {
            throw new \RuntimeException('ManagerRegistry has not been set.');
        }

        $entityManager = $this->managerRegistry->getManager('default');
        $userRepository = $entityManager->getRepository(Users::class);
        return $userRepository->find($this->users);
    }

    public function setUser(Users $users): static
    {
        $this->users = $users->getId();

        return $this;
    }

    public function setManagerRegistry(ManagerRegistry $managerRegistry): static
    {
        $this->managerRegistry = $managerRegistry;

        return $this;
    }
}

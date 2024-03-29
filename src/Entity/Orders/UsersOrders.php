<?php

namespace App\Entity\Orders;

use App\Entity\Users\Users;
use App\Repository\Orders\UsersOrdersRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UsersOrdersRepository::class)]
#[ORM\Table(name: 'usersOrders', schema: 'db_orders')]
#[ORM\HasLifecycleCallbacks]
class UsersOrders
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'usersOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $orders = null;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $users = null;

    #[ORM\Column(length: 50)]
    private ?string $payment_intent = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

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

    public function getPaymentIntent(): ?string
    {
        return $this->payment_intent;
    }

    public function setPaymentIntent(string $payment_intent): static
    {
        $this->payment_intent = $payment_intent;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

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

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getUser(): ?Users
    {
        $entityManager = ManagerRegistry::class->getManager('default');
        $userRepository = $entityManager->getRepository(Users::class);
        return $userRepository->find($this->users);
    }

    public function setUsers(Users $users): static
    {
        $this->users = $users->getId();

        return $this;
    }
}

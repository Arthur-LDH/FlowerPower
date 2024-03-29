<?php

namespace App\Entity\Orders;

use App\Entity\Users\Address;
use App\Repository\Orders\OrdersRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
#[ORM\Table(name: 'order', schema: 'db_orders')]
#[ORM\HasLifecycleCallbacks]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $payed_at = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(targetEntity: OrderPricingSellerOrErp::class, mappedBy: 'orders')]
    private Collection $orderPricingSellerOrErps;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $address = null;

    #[ORM\OneToMany(targetEntity: UsersOrders::class, mappedBy: 'orders', orphanRemoval: true)]
    private Collection $usersOrders;

    public function __construct()
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
        $this->orderPricingSellerOrErps = new ArrayCollection();
        $this->usersOrders = new ArrayCollection();
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPayedAt(): ?\DateTimeInterface
    {
        return $this->payed_at;
    }

    public function setPayedAt(\DateTimeInterface $payed_at): static
    {
        $this->payed_at = $payed_at;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

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

    /**
     * @return Collection<int, OrderPricingSellerOrErp>
     */
    public function getOrderPricingSellerOrErps(): Collection
    {
        return $this->orderPricingSellerOrErps;
    }

    public function addOrderPricingSellerOrErp(OrderPricingSellerOrErp $orderPricingSellerOrErp): static
    {
        if (!$this->orderPricingSellerOrErps->contains($orderPricingSellerOrErp)) {
            $this->orderPricingSellerOrErps->add($orderPricingSellerOrErp);
            $orderPricingSellerOrErp->setOrders($this);
        }

        return $this;
    }

    public function removeOrderPricingSellerOrErp(OrderPricingSellerOrErp $orderPricingSellerOrErp): static
    {
        if ($this->orderPricingSellerOrErps->removeElement($orderPricingSellerOrErp)) {
            // set the owning side to null (unless already changed)
            if ($orderPricingSellerOrErp->getOrders() === $this) {
                $orderPricingSellerOrErp->setOrders(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        $entityManager = ManagerRegistry::class->getManager('default');
        $addressRepository = $entityManager->getRepository(Address::class);
        return $addressRepository->find($this->address);
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address->getId();

        return $this;
    }

    /**
     * @return Collection<int, UsersOrders>
     */
    public function getUsersOrders(): Collection
    {
        return $this->usersOrders;
    }

    public function addUsersOrder(UsersOrders $usersOrder): static
    {
        if (!$this->usersOrders->contains($usersOrder)) {
            $this->usersOrders->add($usersOrder);
            $usersOrder->setOrders($this);
        }

        return $this;
    }

    public function removeUsersOrder(UsersOrders $usersOrder): static
    {
        if ($this->usersOrders->removeElement($usersOrder)) {
            // set the owning side to null (unless already changed)
            if ($usersOrder->getOrders() === $this) {
                $usersOrder->setOrders(null);
            }
        }

        return $this;
    }
}

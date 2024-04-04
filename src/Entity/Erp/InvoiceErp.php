<?php

namespace App\Entity\Erp;

use App\Entity\Orders\Orders;
use App\Entity\Orders\UsersOrders;
use App\Entity\Users\Seller;
use App\Repository\Erp\InvoiceErpRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InvoiceErpRepository::class)]
#[ORM\Table(name: 'invoiceErp', schema: 'db_erp')]
class InvoiceErp
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid')]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $orders = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?Uuid $seller = null;

    private ?ManagerRegistry $managerRegistry = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getOrders(): array
    {
        if (!$this->managerRegistry) {
            throw new \RuntimeException('ManagerRegistry has not been set.');
        }

        $entityManager = $this->managerRegistry->getManager('orders');
        $userOrderRepository = $entityManager->getRepository(UsersOrders::class);
        return $userOrderRepository->findBy(['user' => $this->id]);
    }

    public function setOrders(Orders $orders): static
    {
        $this->orders = $orders->getId();

        return $this;
    }

    public function getSeller(): ?Uuid
    {
        return $this->seller;
    }

    public function setSeller(Seller $seller): static
    {
        $this->seller = $seller->getId();

        return $this;
    }

    public function setManagerRegistry(ManagerRegistry $managerRegistry): static
    {
        $this->managerRegistry = $managerRegistry;

        return $this;
    }
}

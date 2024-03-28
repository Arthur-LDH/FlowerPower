<?php

namespace App\Entity\Erp;

use App\Entity\Orders\UsersOrders;
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

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getOrders(): ?UsersOrders
    {
        $entityManager = ManagerRegistry::class->getManager('orders');
        $userOrderRepository = $entityManager->getRepository(UsersOrders::class);
        return $userOrderRepository->findBy(['user' => $this->id]);
    }

    public function setOrders(Uuid $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getSeller(): ?Uuid
    {
        return $this->seller;
    }

    public function setSeller(Uuid $seller): static
    {
        $this->seller = $seller;

        return $this;
    }
}

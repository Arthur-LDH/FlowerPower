<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'address')]
#[ORM\HasLifecycleCallbacks]
class Address{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?UuidInterface $uid = null;

    //TODO : changer le type et créer les getters setters
    #[ORM\Column(nullable: false)]
    private ?string $coordinates = null;

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


}
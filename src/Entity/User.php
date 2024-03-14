<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
#[ORM\HasLifecycleCallbacks]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?UuidInterface $uid = null;

    #[ORM\Column(unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column (length: 50)]
    private ?string $firstname = null;

    #[ORM\Column (length: 50)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?DateTime $email_verified_at = null;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?string $old_password = null;

    #[ORM\Column (length :100)]
    private ?string $remember_token = null;

    #[ORM\Column]
    private ?DateTime $birthday = null;

    #[ORM\Column]
    private ?string $phone = null;


    #[ORM\Column]
    private ?DateTime $created_at = null;


    #[ORM\Column]
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmailVerifiedAt(): ?DateTime
    {
        return $this->email_verified_at;
    }

    public function setEmailVerifiedAt(?DateTime $email_verified_at): void
    {
        $this->email_verified_at = $email_verified_at;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getOldPassword(): ?string
    {
        return $this->old_password;
    }

    public function setOldPassword(?string $old_password): void
    {
        $this->old_password = $old_password;
    }

    public function getRememberToken(): ?string
    {
        return $this->remember_token;
    }

    public function setRememberToken(?string $remember_token): void
    {
        $this->remember_token = $remember_token;
    }

    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(?DateTime $birthday): void
    {
        $this->birthday = $birthday;
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


}

<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserAddressRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserAddressRepository::class)]
#[ORM\Table(name: 'user_addresses')]
class UserAddress
{

    final public const int TYPE_HOME = 0;

    final public const int TYPE_OFFICE = 1;

    final public const int TYPE_OTHER = 2;

    final public const array TYPES = [
        self::TYPE_HOME   => 'Home',
        self::TYPE_OFFICE => 'Office',
        self::TYPE_OTHER  => 'Other',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $user_id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $commune_id = null;

    #[ORM\Column(length: 500)]
    private ?string $address = null;

    #[ORM\Column(length: 10)]
    private ?string $postal_code = null;

    #[ORM\Column]
    private ?int $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getCommuneId(): ?int
    {
        return $this->commune_id;
    }

    public function setCommuneId(?int $commune_id): void
    {
        $this->commune_id = $commune_id;
    }

}

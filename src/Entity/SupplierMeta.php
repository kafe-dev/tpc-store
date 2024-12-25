<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SupplierMetaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplierMetaRepository::class)]
#[ORM\Table(name: 'supplier_meta')]
class SupplierMeta
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $supplier_id = null;

    #[ORM\Column(length: 255)]
    private ?string $meta_key = null;

    #[ORM\Column]
    private array $meta_value = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetaKey(): ?string
    {
        return $this->meta_key;
    }

    public function setMetaKey(string $meta_key): static
    {
        $this->meta_key = $meta_key;

        return $this;
    }

    public function getMetaValue(): array
    {
        return $this->meta_value;
    }

    public function setMetaValue(array $meta_value): static
    {
        $this->meta_value = $meta_value;

        return $this;
    }

    public function getSupplierId(): ?int
    {
        return $this->supplier_id;
    }

    public function setSupplierId(?int $supplier_id): void
    {
        $this->supplier_id = $supplier_id;
    }

}

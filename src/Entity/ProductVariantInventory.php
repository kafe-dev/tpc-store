<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductVariantInventoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductVariantInventoryRepository::class)]
#[ORM\Table(name: 'product_variants_inventories')]
class ProductVariantInventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Inventory::class, inversedBy: 'productVariantInventories')]
    #[ORM\JoinColumn(name: 'inventory_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Inventory $inventory = null;

    #[ORM\ManyToOne(targetEntity: ProductVariant::class, inversedBy: 'productVariantInventories')]
    #[ORM\JoinColumn(name: 'product_variant_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?ProductVariant $product_variant = null;

    #[ORM\Column]
    private ?int $stock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(?Inventory $inventory): static
    {
        $this->inventory = $inventory;

        return $this;
    }

    public function getProductVariant(): ?ProductVariant
    {
        return $this->product_variant;
    }

    public function setProductVariant(?ProductVariant $product_variant): static
    {
        $this->product_variant = $product_variant;

        return $this;
    }
}

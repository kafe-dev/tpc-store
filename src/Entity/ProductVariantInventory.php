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

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $inventory_id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $product_variant_id = null;

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

    public function getInventoryId(): ?int
    {
        return $this->inventory_id;
    }

    public function setInventoryId(?int $inventory_id): void
    {
        $this->inventory_id = $inventory_id;
    }

    public function getProductVariantId(): ?int
    {
        return $this->product_variant_id;
    }

    public function setProductVariantId(?int $product_variant_id): void
    {
        $this->product_variant_id = $product_variant_id;
    }

}

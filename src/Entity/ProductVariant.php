<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductVariantRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductVariantRepository::class)]
#[ORM\Table(name: 'product_variants')]
class ProductVariant
{

    final public const int IS_ON_SALE_NO = 0;

    final public const int IS_ON_SALE_YES = 1;

    final public const array IS_ON_SALE = [
        self::IS_ON_SALE_NO  => 'No',
        self::IS_ON_SALE_YES => 'Yes',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $product_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 65, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(options: ["default" => self::IS_ON_SALE_NO])]
    private ?int $is_on_sale = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 65, scale: 2, nullable: true)]
    private ?string $sale_price = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $sale_start_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $sale_end_at = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column]
    private ?int $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getOnSale(): ?int
    {
        return $this->is_on_sale;
    }

    public function setOnSale(int $is_on_sale): static
    {
        $this->is_on_sale = $is_on_sale;

        return $this;
    }

    public function getSalePrice(): ?string
    {
        return $this->sale_price;
    }

    public function setSalePrice(?string $sale_price): static
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    public function getSaleStartAt(): ?DateTimeImmutable
    {
        return $this->sale_start_at;
    }

    public function setSaleStartAt(?DateTimeImmutable $sale_start_at): static
    {
        $this->sale_start_at = $sale_start_at;

        return $this;
    }

    public function getSaleEndAt(): ?DateTimeImmutable
    {
        return $this->sale_end_at;
    }

    public function setSaleEndAt(?DateTimeImmutable $sale_end_at): static
    {
        $this->sale_end_at = $sale_end_at;

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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(?int $product_id): void
    {
        $this->product_id = $product_id;
    }

}

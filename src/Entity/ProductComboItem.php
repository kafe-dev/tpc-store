<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductComboItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductComboItemRepository::class)]
#[ORM\Table(name: 'product_combo_items')]
class ProductComboItem
{

    final public const int DISCOUNT_TYPE_PERCENTAGE = 0;

    final public const int DISCOUNT_TYPE_FLAT = 1;

    final public const array DISCOUNT_TYPES = [
        self::DISCOUNT_TYPE_PERCENTAGE => 'Percentage',
        self::DISCOUNT_TYPE_FLAT       => 'Flat',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $parent_id = null;

    #[ORM\Column]
    private array $child_ids = [];

    #[ORM\Column(type: Types::DECIMAL, precision: 65, scale: 2)]
    private ?string $discount_amount = null;

    #[ORM\Column]
    private ?int $discount_type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChildIds(): array
    {
        return $this->child_ids;
    }

    public function setChildIds(array $child_ids): static
    {
        $this->child_ids = $child_ids;

        return $this;
    }

    public function getDiscountAmount(): ?string
    {
        return $this->discount_amount;
    }

    public function setDiscountAmount(string $discount_amount): static
    {
        $this->discount_amount = $discount_amount;

        return $this;
    }

    public function getDiscountType(): ?int
    {
        return $this->discount_type;
    }

    public function setDiscountType(int $discount_type): static
    {
        $this->discount_type = $discount_type;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): void
    {
        $this->parent_id = $parent_id;
    }

}

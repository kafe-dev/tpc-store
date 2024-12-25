<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductVariantAttributeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductVariantAttributeRepository::class)]
#[ORM\Table(name: 'product_variants_attributes')]
class ProductVariantAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $product_variant_id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $attribute_id = null;


    #[ORM\ManyToOne(targetEntity: ProductVariant::class, cascade: ['persist', 'remove'], inversedBy: 'productVariantsAttributes')]
    #[ORM\JoinColumn(name: 'product_variant_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?ProductVariant $product_variant = null;

    #[ORM\ManyToOne(targetEntity: Attribute::class, cascade: ['persist', 'remove'], inversedBy: 'productVariantsAttributes')]
    #[ORM\JoinColumn(name: 'attribute_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Attribute $attribute = null;
    public function getId(): ?int
    {
        return $this->id;
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

    public function getAttribute(): ?Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(?Attribute $attribute): static
    {
        $this->attribute = $attribute;

        return $this;
    }
}

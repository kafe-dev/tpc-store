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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductVariantId(): ?int
    {
        return $this->product_variant_id;
    }

    public function setProductVariantId(?int $product_variant_id): void
    {
        $this->product_variant_id = $product_variant_id;
    }

    public function getAttributeId(): ?int
    {
        return $this->attribute_id;
    }

    public function setAttributeId(?int $attribute_id): void
    {
        $this->attribute_id = $attribute_id;
    }

}

<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductVariantImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductVariantImageRepository::class)]
#[ORM\Table(name: 'product_variant_images')]
class ProductVariantImage
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $product_variant_id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

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

    public function getProductVariantId(): ?int
    {
        return $this->product_variant_id;
    }

    public function setProductVariantId(?int $product_variant_id): void
    {
        $this->product_variant_id = $product_variant_id;
    }

}

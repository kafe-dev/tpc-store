<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductVariantSaleEventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductVariantSaleEventRepository::class)]
#[ORM\Table(name: 'product_variants_sale_events')]
class ProductVariantSaleEvent
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $product_variant_id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $sale_event_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getSaleEventId(): ?int
    {
        return $this->sale_event_id;
    }

    public function setSaleEventId(?int $sale_event_id): void
    {
        $this->sale_event_id = $sale_event_id;
    }

}

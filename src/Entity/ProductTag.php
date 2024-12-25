<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductTagRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductTagRepository::class)]
#[ORM\Table(name: 'products_tags')]
class ProductTag
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $product_id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $tag_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(?int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function getTagId(): ?int
    {
        return $this->tag_id;
    }

    public function setTagId(?int $tag_id): void
    {
        $this->tag_id = $tag_id;
    }

}

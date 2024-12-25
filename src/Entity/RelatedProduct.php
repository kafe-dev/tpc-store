<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RelatedProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelatedProductRepository::class)]
#[ORM\Table(name: 'related_products')]
class RelatedProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, cascade: ['persist', 'remove'], inversedBy: 'relatedProducts_from')]
    #[ORM\JoinColumn(name: 'from_target_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Product $from_target = null;

    #[ORM\ManyToOne(targetEntity: Product::class, cascade: ['persist', 'remove'], inversedBy: 'relatedProducts_target')]
    #[ORM\JoinColumn(name: 'target_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Product $target = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromTarget(): ?Product
    {
        return $this->from_target;
    }

    public function setFromTarget(?Product $from_target): static
    {
        $this->from_target = $from_target;

        return $this;
    }

    public function getTarget(): ?Product
    {
        return $this->target;
    }

    public function setTarget(?Product $target): static
    {
        $this->target = $target;

        return $this;
    }

}

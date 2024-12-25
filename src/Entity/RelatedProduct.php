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

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $from_target_id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $target_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromTargetId(): ?int
    {
        return $this->from_target_id;
    }

    public function setFromTargetId(?int $from_target_id): void
    {
        $this->from_target_id = $from_target_id;
    }

    public function getTargetId(): ?int
    {
        return $this->target_id;
    }

    public function setTargetId(?int $target_id): void
    {
        $this->target_id = $target_id;
    }

}

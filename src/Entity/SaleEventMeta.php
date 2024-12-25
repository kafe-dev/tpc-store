<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SaleEventMetaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleEventMetaRepository::class)]
#[ORM\Table(name: 'sale_events_meta')]
class SaleEventMeta
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $sale_event_id = null;

    #[ORM\Column(length: 255)]
    private ?string $meta_key = null;

    #[ORM\Column]
    private array $meta_value = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetaKey(): ?string
    {
        return $this->meta_key;
    }

    public function setMetaKey(string $meta_key): static
    {
        $this->meta_key = $meta_key;

        return $this;
    }

    public function getMetaValue(): array
    {
        return $this->meta_value;
    }

    public function setMetaValue(array $meta_value): static
    {
        $this->meta_value = $meta_value;

        return $this;
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

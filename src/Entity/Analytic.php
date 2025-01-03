<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnalyticRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnalyticRepository::class)]
#[ORM\Table(name: 'analytics')]
#[ORM\HasLifecycleCallbacks]
class Analytic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: AnalyticCategory::class, inversedBy: 'analytics')]
    #[ORM\JoinColumn(name: 'analytic_category_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?AnalyticCategory $analytic_category = null;

    #[ORM\Column]
    private array $data = [];

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $updated_at = null;

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function lifecycle(): void
    {
        $this->setUpdatedAt(new DateTimeImmutable());

        if (is_null($this->getCreatedAt())) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getAnalyticCategory(): ?AnalyticCategory
    {
        return $this->analytic_category;
    }

    public function setAnalyticCategory(?AnalyticCategory $analytic_category): static
    {
        $this->analytic_category = $analytic_category;

        return $this;
    }

}

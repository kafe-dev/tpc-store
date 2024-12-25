<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnalyticCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnalyticCategoryRepository::class)]
#[ORM\Table(name: 'analytic_categories')]
class AnalyticCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Analytic::class, mappedBy: 'analytic_category', orphanRemoval: true)]
    private Collection $analytics;
    public function __construct()
    {
        $this->analytics = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
    /**
     * @return Collection<int, Analytic>
     */
    public function getAnalytics(): Collection
    {
        return $this->analytics;
    }

    public function addAnalytic(Analytic $analytic): static
    {
        if (!$this->analytics->contains($analytic)) {
            $this->analytics->add($analytic);
            $analytic->setAnalyticCategory($this);
        }

        return $this;
    }

    public function removeAnalytic(Analytic $analytic): static
    {
        if ($this->analytics->removeElement($analytic)) {
            // set the owning side to null (unless already changed)
            if ($analytic->getAnalyticCategory() === $this) {
                $analytic->setAnalyticCategory(null);
            }
        }

        return $this;
    }
}

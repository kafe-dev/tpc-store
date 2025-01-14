<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\Table(name: 'tags')]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_keyword = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_description = null;

    /**
     * @var Collection<int, ProductTag>
     */
    #[ORM\OneToMany(targetEntity: ProductTag::class, mappedBy: 'tag', orphanRemoval: true)]
    private Collection $productsTags;

    public function __construct()
    {
        $this->productsTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getMetaKeyword(): ?string
    {
        return $this->meta_keyword;
    }

    public function setMetaKeyword(?string $meta_keyword): static
    {
        $this->meta_keyword = $meta_keyword;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(?string $meta_description): static
    {
        $this->meta_description = $meta_description;

        return $this;
    }
    /**
     * @return Collection<int, ProductTag>
     */
    public function getProductsTags(): Collection
    {
        return $this->productsTags;
    }

    public function addProductsTag(ProductTag $productsTag): static
    {
        if (!$this->productsTags->contains($productsTag)) {
            $this->productsTags->add($productsTag);
            $productsTag->setTag($this);
        }

        return $this;
    }

    public function removeProductsTag(ProductTag $productsTag): static
    {
        if ($this->productsTags->removeElement($productsTag)) {
            // set the owning side to null (unless already changed)
            if ($productsTag->getTag() === $this) {
                $productsTag->setTag(null);
            }
        }

        return $this;
    }
}

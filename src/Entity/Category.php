<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'categories')]
class Category
{
    final public const int STATUS_INACTIVE = 0;

    final public const int STATUS_ACTIVE = 1;

    final public const int STATUS_DRAFT = 2;

    final public const array STATUS = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_DRAFT    => 'Draft',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'children', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private Collection $parent;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_keyword = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_description = null;

    #[ORM\Column(options: ["default" => self::STATUS_INACTIVE])]
    private ?int $status = null;
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent')]
    private ?self $children = null;

    /**
     * @var Collection<int, ProductCategory>
     */
    #[ORM\OneToMany(targetEntity: ProductCategory::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $productsCategories;

    public function __construct()
    {
        $this->parent = new ArrayCollection();
        $this->productsCategories = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }
    public function getChildren(): ?self
    {
        return $this->children;
    }

    public function setChildren(?self $children): static
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): static
    {
        if (!$this->parent->contains($parent)) {
            $this->parent->add($parent);
            $parent->setChildren($this);
        }

        return $this;
    }

    public function removeParent(self $parent): static
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getChildren() === $this) {
                $parent->setChildren(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductCategory>
     */
    public function getProductsCategories(): Collection
    {
        return $this->productsCategories;
    }

    public function addProductsCategory(ProductCategory $productsCategory): static
    {
        if (!$this->productsCategories->contains($productsCategory)) {
            $this->productsCategories->add($productsCategory);
            $productsCategory->setCategory($this);
        }

        return $this;
    }

    public function removeProductsCategory(ProductCategory $productsCategory): static
    {
        if ($this->productsCategories->removeElement($productsCategory)) {
            // set the owning side to null (unless already changed)
            if ($productsCategory->getCategory() === $this) {
                $productsCategory->setCategory(null);
            }
        }

        return $this;
    }

}
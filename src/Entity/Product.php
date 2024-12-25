<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
#[ORM\HasLifecycleCallbacks]
class Product
{
    final public const int TYPE_SIMPLE = 0;

    final public const int TYPE_VARIANT = 1;

    final public const array TYPES = [
        self::TYPE_SIMPLE  => 'Simple',
        self::TYPE_VARIANT => 'Variant',
    ];

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

    #[ORM\ManyToOne(targetEntity: Supplier::class, cascade: ['persist', 'remove'], inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'supplier_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Supplier $supplier = null;

    #[ORM\Column(length: 255)]
    private ?string $sku = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 500)]
    private ?string $short_description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 65, scale: 2)]
    private ?string $original_price = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $thumbnail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_keyword = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_description = null;

    #[ORM\Column(options: ["default" => self::STATUS_ACTIVE])]
    private ?int $status = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, ProductCategory>
     */
    #[ORM\OneToMany(targetEntity: ProductCategory::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $productsCategories;

    /**
     * @var Collection<int, ProductReview>
     */
    #[ORM\OneToMany(targetEntity: ProductReview::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $productReviews;

    /**
     * @var Collection<int, ProductTag>
     */
    #[ORM\OneToMany(targetEntity: ProductTag::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $productsTags;

    /**
     * @var Collection<int, RelatedProduct>
     */
    #[ORM\OneToMany(targetEntity: RelatedProduct::class, mappedBy: 'from_target', orphanRemoval: true)]
    private Collection $relatedProducts_from;

    /**
     * @var Collection<int, RelatedProduct>
     */
    #[ORM\OneToMany(targetEntity: RelatedProduct::class, mappedBy: 'target', orphanRemoval: true)]
    private Collection $relatedProducts_target;

    /**
     * @var Collection<int, ProductComboItem>
     */
    #[ORM\OneToMany(targetEntity: ProductComboItem::class, mappedBy: 'parent', orphanRemoval: true)]
    private Collection $productComboItems;

    /**
     * @var Collection<int, ProductVariant>
     */
    #[ORM\OneToMany(targetEntity: ProductVariant::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $productVariants;

    /**
     * @var Collection<int, Wishlist>
     */
    #[ORM\OneToMany(targetEntity: Wishlist::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $wishlists;

    public function __construct()
    {
        $this->productsCategories = new ArrayCollection();
        $this->productReviews = new ArrayCollection();
        $this->productsTags = new ArrayCollection();
        $this->relatedProducts_from = new ArrayCollection();
        $this->relatedProducts_target = new ArrayCollection();
        $this->productComboItems = new ArrayCollection();
        $this->productVariants = new ArrayCollection();
        $this->wishlists = new ArrayCollection();
    }
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

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

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): static
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getOriginalPrice(): ?string
    {
        return $this->original_price;
    }

    public function setOriginalPrice(string $original_price): static
    {
        $this->original_price = $original_price;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

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
            $productsCategory->setProduct($this);
        }

        return $this;
    }

    public function removeProductsCategory(ProductCategory $productsCategory): static
    {
        if ($this->productsCategories->removeElement($productsCategory)) {
            // set the owning side to null (unless already changed)
            if ($productsCategory->getProduct() === $this) {
                $productsCategory->setProduct(null);
            }
        }

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * @return Collection<int, ProductReview>
     */
    public function getProductReviews(): Collection
    {
        return $this->productReviews;
    }

    public function addProductReview(ProductReview $productReview): static
    {
        if (!$this->productReviews->contains($productReview)) {
            $this->productReviews->add($productReview);
            $productReview->setProduct($this);
        }

        return $this;
    }

    public function removeProductReview(ProductReview $productReview): static
    {
        if ($this->productReviews->removeElement($productReview)) {
            // set the owning side to null (unless already changed)
            if ($productReview->getProduct() === $this) {
                $productReview->setProduct(null);
            }
        }

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
            $productsTag->setProduct($this);
        }

        return $this;
    }

    public function removeProductsTag(ProductTag $productsTag): static
    {
        if ($this->productsTags->removeElement($productsTag)) {
            // set the owning side to null (unless already changed)
            if ($productsTag->getProduct() === $this) {
                $productsTag->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RelatedProduct>
     */
    public function getRelatedProductsFrom(): Collection
    {
        return $this->relatedProducts_from;
    }

    public function addRelatedProductsFrom(RelatedProduct $relatedProductsFrom): static
    {
        if (!$this->relatedProducts_from->contains($relatedProductsFrom)) {
            $this->relatedProducts_from->add($relatedProductsFrom);
            $relatedProductsFrom->setFromTarget($this);
        }

        return $this;
    }

    public function removeRelatedProductsFrom(RelatedProduct $relatedProductsFrom): static
    {
        if ($this->relatedProducts_from->removeElement($relatedProductsFrom)) {
            // set the owning side to null (unless already changed)
            if ($relatedProductsFrom->getFromTarget() === $this) {
                $relatedProductsFrom->setFromTarget(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RelatedProduct>
     */
    public function getRelatedProductsTarget(): Collection
    {
        return $this->relatedProducts_target;
    }

    public function addRelatedProductsTarget(RelatedProduct $relatedProductsTarget): static
    {
        if (!$this->relatedProducts_target->contains($relatedProductsTarget)) {
            $this->relatedProducts_target->add($relatedProductsTarget);
            $relatedProductsTarget->setTarget($this);
        }

        return $this;
    }

    public function removeRelatedProductsTarget(RelatedProduct $relatedProductsTarget): static
    {
        if ($this->relatedProducts_target->removeElement($relatedProductsTarget)) {
            // set the owning side to null (unless already changed)
            if ($relatedProductsTarget->getTarget() === $this) {
                $relatedProductsTarget->setTarget(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductComboItem>
     */
    public function getProductComboItems(): Collection
    {
        return $this->productComboItems;
    }

    public function addProductComboItem(ProductComboItem $productComboItem): static
    {
        if (!$this->productComboItems->contains($productComboItem)) {
            $this->productComboItems->add($productComboItem);
            $productComboItem->setParent($this);
        }

        return $this;
    }

    public function removeProductComboItem(ProductComboItem $productComboItem): static
    {
        if ($this->productComboItems->removeElement($productComboItem)) {
            // set the owning side to null (unless already changed)
            if ($productComboItem->getParent() === $this) {
                $productComboItem->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductVariant>
     */
    public function getProductVariants(): Collection
    {
        return $this->productVariants;
    }

    public function addProductVariant(ProductVariant $productVariant): static
    {
        if (!$this->productVariants->contains($productVariant)) {
            $this->productVariants->add($productVariant);
            $productVariant->setProduct($this);
        }

        return $this;
    }

    public function removeProductVariant(ProductVariant $productVariant): static
    {
        if ($this->productVariants->removeElement($productVariant)) {
            // set the owning side to null (unless already changed)
            if ($productVariant->getProduct() === $this) {
                $productVariant->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Wishlist>
     */
    public function getWishlists(): Collection
    {
        return $this->wishlists;
    }

    public function addWishlist(Wishlist $wishlist): static
    {
        if (!$this->wishlists->contains($wishlist)) {
            $this->wishlists->add($wishlist);
            $wishlist->setProduct($this);
        }

        return $this;
    }

    public function removeWishlist(Wishlist $wishlist): static
    {
        if ($this->wishlists->removeElement($wishlist)) {
            // set the owning side to null (unless already changed)
            if ($wishlist->getProduct() === $this) {
                $wishlist->setProduct(null);
            }
        }

        return $this;
    }

}

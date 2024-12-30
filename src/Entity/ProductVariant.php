<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductVariantRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductVariantRepository::class)]
#[ORM\Table(name: 'product_variants')]
class ProductVariant
{
    final public const int IS_ON_SALE_NO = 0;

    final public const int IS_ON_SALE_YES = 1;

    final public const array IS_ON_SALE = [
        self::IS_ON_SALE_NO  => 'No',
        self::IS_ON_SALE_YES => 'Yes',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'productVariants')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Product $product = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 65, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(options: ["default" => self::IS_ON_SALE_NO])]
    private ?int $is_on_sale = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 65, scale: 2, nullable: true)]
    private ?string $sale_price = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $sale_start_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $sale_end_at = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column]
    private ?int $position = null;

    /**
     * @var Collection<int, ProductVariantAttribute>
     */
    #[ORM\OneToMany(targetEntity: ProductVariantAttribute::class, mappedBy: 'product_variant', orphanRemoval: true)]
    private Collection $productVariantsAttributes;

    /**
     * @var Collection<int, ProductVariantImage>
     */
    #[ORM\OneToMany(targetEntity: ProductVariantImage::class, mappedBy: 'product_variant', orphanRemoval: true)]
    private Collection $productVariantImages;

    /**
     * @var Collection<int, ProductVariantSaleEvent>
     */
    #[ORM\OneToMany(targetEntity: ProductVariantSaleEvent::class, mappedBy: 'product_variant', orphanRemoval: true)]
    private Collection $productVariantSaleEvents;

    /**
     * @var Collection<int, ProductVariantInventory>
     */
    #[ORM\OneToMany(targetEntity: ProductVariantInventory::class, mappedBy: 'product_variant', orphanRemoval: true)]
    private Collection $productVariantInventories;

    public function __construct()
    {
        $this->productVariantsAttributes = new ArrayCollection();
        $this->productVariantImages = new ArrayCollection();
        $this->productVariantSaleEvents = new ArrayCollection();
        $this->productVariantInventories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getOnSale(): ?int
    {
        return $this->is_on_sale;
    }

    public function setOnSale(int $is_on_sale): static
    {
        $this->is_on_sale = $is_on_sale;

        return $this;
    }

    public function getSalePrice(): ?string
    {
        return $this->sale_price;
    }

    public function setSalePrice(?string $sale_price): static
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    public function getSaleStartAt(): ?DateTimeImmutable
    {
        return $this->sale_start_at;
    }

    public function setSaleStartAt(?DateTimeImmutable $sale_start_at): static
    {
        $this->sale_start_at = $sale_start_at;

        return $this;
    }

    public function getSaleEndAt(): ?DateTimeImmutable
    {
        return $this->sale_end_at;
    }

    public function setSaleEndAt(?DateTimeImmutable $sale_end_at): static
    {
        $this->sale_end_at = $sale_end_at;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, ProductVariantAttribute>
     */
    public function getProductVariantsAttributes(): Collection
    {
        return $this->productVariantsAttributes;
    }

    public function addProductVariantsAttribute(ProductVariantAttribute $productVariantsAttribute): static
    {
        if (!$this->productVariantsAttributes->contains($productVariantsAttribute)) {
            $this->productVariantsAttributes->add($productVariantsAttribute);
            $productVariantsAttribute->setProductVariant($this);
        }

        return $this;
    }

    public function removeProductVariantsAttribute(ProductVariantAttribute $productVariantsAttribute): static
    {
        if ($this->productVariantsAttributes->removeElement($productVariantsAttribute)) {
            // set the owning side to null (unless already changed)
            if ($productVariantsAttribute->getProductVariant() === $this) {
                $productVariantsAttribute->setProductVariant(null);
            }
        }

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection<int, ProductVariantImage>
     */
    public function getProductVariantImages(): Collection
    {
        return $this->productVariantImages;
    }

    public function addProductVariantImage(ProductVariantImage $productVariantImage): static
    {
        if (!$this->productVariantImages->contains($productVariantImage)) {
            $this->productVariantImages->add($productVariantImage);
            $productVariantImage->setProductVariant($this);
        }

        return $this;
    }

    public function removeProductVariantImage(ProductVariantImage $productVariantImage): static
    {
        if ($this->productVariantImages->removeElement($productVariantImage)) {
            // set the owning side to null (unless already changed)
            if ($productVariantImage->getProductVariant() === $this) {
                $productVariantImage->setProductVariant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductVariantSaleEvent>
     */
    public function getProductVariantSaleEvents(): Collection
    {
        return $this->productVariantSaleEvents;
    }

    public function addProductVariantSaleEvent(ProductVariantSaleEvent $productVariantSaleEvent): static
    {
        if (!$this->productVariantSaleEvents->contains($productVariantSaleEvent)) {
            $this->productVariantSaleEvents->add($productVariantSaleEvent);
            $productVariantSaleEvent->setProductVariant($this);
        }

        return $this;
    }

    public function removeProductVariantSaleEvent(ProductVariantSaleEvent $productVariantSaleEvent): static
    {
        if ($this->productVariantSaleEvents->removeElement($productVariantSaleEvent)) {
            // set the owning side to null (unless already changed)
            if ($productVariantSaleEvent->getProductVariant() === $this) {
                $productVariantSaleEvent->setProductVariant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductVariantInventory>
     */
    public function getProductVariantInventories(): Collection
    {
        return $this->productVariantInventories;
    }

    public function addProductVariantInventory(ProductVariantInventory $productVariantInventory): static
    {
        if (!$this->productVariantInventories->contains($productVariantInventory)) {
            $this->productVariantInventories->add($productVariantInventory);
            $productVariantInventory->setProductVariant($this);
        }

        return $this;
    }

    public function removeProductVariantInventory(ProductVariantInventory $productVariantInventory): static
    {
        if ($this->productVariantInventories->removeElement($productVariantInventory)) {
            // set the owning side to null (unless already changed)
            if ($productVariantInventory->getProductVariant() === $this) {
                $productVariantInventory->setProductVariant(null);
            }
        }

        return $this;
    }

}

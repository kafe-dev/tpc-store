<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SaleEventRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleEventRepository::class)]
#[ORM\Table(name: 'sale_events')]
#[ORM\HasLifecycleCallbacks]
class SaleEvent
{
    final public const int DISCOUNT_TYPE_PERCENTAGE = 0;

    final public const int DISCOUNT_TYPE_FLAT = 1;

    final public const array DISCOUNT_TYPES = [
        self::DISCOUNT_TYPE_PERCENTAGE => 'Percentage',
        self::DISCOUNT_TYPE_FLAT       => 'Flat',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 65, scale: 2)]
    private ?string $discount_amount = null;

    #[ORM\Column]
    private ?int $discount_type = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $start_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $end_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, SaleEventMeta>
     */
    #[ORM\OneToMany(targetEntity: SaleEventMeta::class, mappedBy: 'sale_event', orphanRemoval: true)]
    private Collection $saleEventsMetas;

    /**
     * @var Collection<int, ProductVariantSaleEvent>
     */
    #[ORM\OneToMany(targetEntity: ProductVariantSaleEvent::class, mappedBy: 'sale_event', orphanRemoval: true)]
    private Collection $productVariantSaleEvents;

    public function __construct()
    {
        $this->saleEventsMetas = new ArrayCollection();
        $this->productVariantSaleEvents = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDiscountAmount(): ?string
    {
        return $this->discount_amount;
    }

    public function setDiscountAmount(string $discount_amount): static
    {
        $this->discount_amount = $discount_amount;

        return $this;
    }

    public function getDiscountType(): ?int
    {
        return $this->discount_type;
    }

    public function setDiscountType(int $discount_type): static
    {
        $this->discount_type = $discount_type;

        return $this;
    }

    public function getStartAt(): ?DateTimeImmutable
    {
        return $this->start_at;
    }

    public function setStartAt(?DateTimeImmutable $start_at): static
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getEndAt(): ?DateTimeImmutable
    {
        return $this->end_at;
    }

    public function setEndAt(?DateTimeImmutable $end_at): static
    {
        $this->end_at = $end_at;

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
     * @return Collection<int, SaleEventMeta>
     */
    public function getSaleEventsMetas(): Collection
    {
        return $this->saleEventsMetas;
    }

    public function addSaleEventsMeta(SaleEventMeta $saleEventsMeta): static
    {
        if (!$this->saleEventsMetas->contains($saleEventsMeta)) {
            $this->saleEventsMetas->add($saleEventsMeta);
            $saleEventsMeta->setSaleEvent($this);
        }

        return $this;
    }

    public function removeSaleEventsMeta(SaleEventMeta $saleEventsMeta): static
    {
        if ($this->saleEventsMetas->removeElement($saleEventsMeta)) {
            // set the owning side to null (unless already changed)
            if ($saleEventsMeta->getSaleEvent() === $this) {
                $saleEventsMeta->setSaleEvent(null);
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
            $productVariantSaleEvent->setSaleEvent($this);
        }

        return $this;
    }

    public function removeProductVariantSaleEvent(ProductVariantSaleEvent $productVariantSaleEvent): static
    {
        if ($this->productVariantSaleEvents->removeElement($productVariantSaleEvent)) {
            // set the owning side to null (unless already changed)
            if ($productVariantSaleEvent->getSaleEvent() === $this) {
                $productVariantSaleEvent->setSaleEvent(null);
            }
        }

        return $this;
    }

}

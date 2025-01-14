<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\InventoryRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryRepository::class)]
#[ORM\Table(name: 'inventories')]
#[ORM\HasLifecycleCallbacks]
class Inventory
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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Commune::class, inversedBy: 'inventories')]
    #[ORM\JoinColumn(name: 'commune_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Commune $commune = null;

    #[ORM\Column(length: 500)]
    private ?string $address = null;

    #[ORM\Column(length: 10)]
    private ?string $postal_code = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\Column]
    private ?int $priority = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $updated_at = null;
    /**
     * @var Collection<int, ProductVariantInventory>
     */
    #[ORM\OneToMany(targetEntity: ProductVariantInventory::class, mappedBy: 'inventory', orphanRemoval: true)]
    private Collection $productVariantInventories;

    public function __construct()
    {
        $this->productVariantInventories = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): static
    {
        $this->postal_code = $postal_code;

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

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

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

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): static
    {
        $this->commune = $commune;

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
            $productVariantInventory->setInventory($this);
        }

        return $this;
    }

    public function removeProductVariantInventory(ProductVariantInventory $productVariantInventory): static
    {
        if ($this->productVariantInventories->removeElement($productVariantInventory)) {
            // set the owning side to null (unless already changed)
            if ($productVariantInventory->getInventory() === $this) {
                $productVariantInventory->setInventory(null);
            }
        }

        return $this;
    }
}

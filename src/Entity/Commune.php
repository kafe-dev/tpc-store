<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
#[ORM\Table(name: 'communes')]
class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\ManyToOne(targetEntity: District::class, cascade: ['persist', 'remove'], inversedBy: 'communes')]
    #[ORM\JoinColumn(name: 'district_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?District $district = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 65, scale: 8)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 65, scale: 8)]
    private ?string $longitude = null;
    #[ORM\OneToOne(targetEntity: UserAddress::class, mappedBy: 'commune', cascade: ['persist', 'remove'])]
    private ?UserAddress $userAddresses = null;

    /**
     * @var Collection<int, Inventory>
     */
    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'commune', orphanRemoval: true)]
    private Collection $inventories;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getUserAddresses(): ?UserAddress
    {
        return $this->userAddresses;
    }

    public function setUserAddresses(UserAddress $userAddresses): static
    {
        // set the owning side of the relation if necessary
        if ($userAddresses->getCommune() !== $this) {
            $userAddresses->setCommune($this);
        }

        $this->userAddresses = $userAddresses;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): static
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return Collection<int, Inventory>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): static
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories->add($inventory);
            $inventory->setCommune($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): static
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getCommune() === $this) {
                $inventory->setCommune(null);
            }
        }

        return $this;
    }

}

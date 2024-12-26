<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\LoyaltyRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoyaltyRepository::class)]
#[ORM\Table(name: 'loyalties')]
#[ORM\HasLifecycleCallbacks]
class Loyalty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist', 'remove'], inversedBy: 'loyalties')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column]
    private ?int $point = null;

    #[ORM\Column(length: 500)]
    private ?string $note = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, LoyaltyCoupon>
     */
    #[ORM\OneToMany(targetEntity: LoyaltyCoupon::class, mappedBy: 'loyalty', orphanRemoval: true)]
    private Collection $loyaltyCoupons;

    public function __construct()
    {
        $this->loyaltyCoupons = new ArrayCollection();
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

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): static
    {
        $this->point = $point;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, LoyaltyCoupon>
     */
    public function getLoyaltyCoupons(): Collection
    {
        return $this->loyaltyCoupons;
    }

    public function addLoyaltyCoupon(LoyaltyCoupon $loyaltyCoupon): static
    {
        if (!$this->loyaltyCoupons->contains($loyaltyCoupon)) {
            $this->loyaltyCoupons->add($loyaltyCoupon);
            $loyaltyCoupon->setLoyalty($this);
        }

        return $this;
    }

    public function removeLoyaltyCoupon(LoyaltyCoupon $loyaltyCoupon): static
    {
        if ($this->loyaltyCoupons->removeElement($loyaltyCoupon)) {
            // set the owning side to null (unless already changed)
            if ($loyaltyCoupon->getLoyalty() === $this) {
                $loyaltyCoupon->setLoyalty(null);
            }
        }

        return $this;
    }

}

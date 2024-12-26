<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CouponRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[ORM\Table(name: 'coupons')]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column]
    private ?int $limit_quantity = null;

    #[ORM\Column]
    private ?int $per_customer = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $expired_at = null;
    #[ORM\OneToMany(targetEntity: LoyaltyCoupon::class, mappedBy: 'coupon', orphanRemoval: true)]
    private Collection $loyaltyCoupons;

    public function __construct()
    {
        $this->loyaltyCoupons = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getLimitQuantity(): ?int
    {
        return $this->limit_quantity;
    }

    public function setLimitQuantity(int $limit_quantity): static
    {
        $this->limit_quantity = $limit_quantity;

        return $this;
    }

    public function getPerCustomer(): ?int
    {
        return $this->per_customer;
    }

    public function setPerCustomer(int $per_customer): static
    {
        $this->per_customer = $per_customer;

        return $this;
    }

    public function getExpiredAt(): ?DateTimeImmutable
    {
        return $this->expired_at;
    }

    public function setExpiredAt(DateTimeImmutable $expired_at): static
    {
        $this->expired_at = $expired_at;

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
            $loyaltyCoupon->setCoupon($this);
        }

        return $this;
    }

    public function removeLoyaltyCoupon(LoyaltyCoupon $loyaltyCoupon): static
    {
        if ($this->loyaltyCoupons->removeElement($loyaltyCoupon)) {
            // set the owning side to null (unless already changed)
            if ($loyaltyCoupon->getCoupon() === $this) {
                $loyaltyCoupon->setCoupon(null);
            }
        }

        return $this;
    }
}

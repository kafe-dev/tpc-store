<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\LoyaltyCouponRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoyaltyCouponRepository::class)]
#[ORM\Table(name: 'loyalties_coupons')]
class LoyaltyCoupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Loyalty::class, inversedBy: 'loyaltyCoupons')]
    #[ORM\JoinColumn(name: 'loyalty_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Loyalty $loyalty = null;

    #[ORM\ManyToOne(targetEntity: Coupon::class, inversedBy: 'loyaltyCoupons')]
    #[ORM\JoinColumn(name: 'coupon_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Coupon $coupon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLoyalty(): ?Loyalty
    {
        return $this->loyalty;
    }

    public function setLoyalty(?Loyalty $loyalty): static
    {
        $this->loyalty = $loyalty;

        return $this;
    }

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupon $coupon): static
    {
        $this->coupon = $coupon;

        return $this;
    }

}

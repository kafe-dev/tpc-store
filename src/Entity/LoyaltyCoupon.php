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

    #[ORM\Column(type: Types::BIGINT)]
    private ?int $loyalty_id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?int $coupon_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLoyaltyId(): ?int
    {
        return $this->loyalty_id;
    }

    public function setLoyaltyId(?int $loyalty_id): void
    {
        $this->loyalty_id = $loyalty_id;
    }

    public function getCouponId(): ?int
    {
        return $this->coupon_id;
    }

    public function setCouponId(?int $coupon_id): void
    {
        $this->coupon_id = $coupon_id;
    }

}

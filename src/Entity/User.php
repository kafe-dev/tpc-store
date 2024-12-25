<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[UniqueEntity('username')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    final public const string ROLE_USER = 'ROLE_USER';

    final public const string ROLE_ADMIN = 'ROLE_ADMIN';

    final public const array ROLES = [
        self::ROLE_USER  => 'User',
        self::ROLE_ADMIN => 'Administrator',
    ];

    final public const int STATUS_INACTIVE = 0;

    final public const int STATUS_ACTIVE = 1;

    final public const int STATUS_BLOCKED = 2;

    final public const array STATUS = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_BLOCKED  => 'Blocked',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $parent_id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $password;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(options: ["default" => self::STATUS_INACTIVE])]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $email_verified_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $last_login_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $blocked_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles   = $this->roles;
        $roles[] = self::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

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

    public function getEmailVerifiedAt(): ?DateTimeImmutable
    {
        return $this->email_verified_at;
    }

    public function setEmailVerifiedAt(?DateTimeImmutable $email_verified_at): static
    {
        $this->email_verified_at = $email_verified_at;

        return $this;
    }

    public function getLastLoginAt(): ?DateTimeImmutable
    {
        return $this->last_login_at;
    }

    public function setLastLoginAt(?DateTimeImmutable $last_login_at): static
    {
        $this->last_login_at = $last_login_at;

        return $this;
    }

    public function getBlockedAt(): ?DateTimeImmutable
    {
        return $this->blocked_at;
    }

    public function setBlockedAt(?DateTimeImmutable $blocked_at): static
    {
        $this->blocked_at = $blocked_at;

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

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    public function eraseCredentials(): void
    {
        //
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

}

<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    final public const string ROLE_MANAGER = 'ROLE_MANAGER';

    final public const array ROLES = [
        self::ROLE_USER  => 'User',
        self::ROLE_ADMIN => 'Administrator',
        self::ROLE_MANAGER => 'Manager',
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

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'children', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private Collection $parent;

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

    /**
     * @var Collection<int, UserGroup>
     */
    #[ORM\OneToMany(targetEntity: UserGroup::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $usersGroups;

    #[ORM\OneToOne(targetEntity: UserProfile::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserProfile $userProfiles = null;

    /**
     * @var Collection<int, UserAddress>
     */
    #[ORM\OneToMany(targetEntity: UserAddress::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $userAddresses;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent')]
    private ?self $children = null;

    /**
     * @var Collection<int, ProductReview>
     */
    #[ORM\OneToMany(targetEntity: ProductReview::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $productReviews;

    /**
     * @var Collection<int, Wishlist>
     */
    #[ORM\OneToMany(targetEntity: Wishlist::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $wishlists;

    /**
     * @var Collection<int, Loyalty>
     */
    #[ORM\OneToMany(targetEntity: Loyalty::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $loyalties;

    /**
     * @var Collection<int, Contact>
     */
    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $contacts;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'sender', orphanRemoval: true)]
    private Collection $senderNotis;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'receiver', orphanRemoval: true)]
    private Collection $receiverNotis;

    public function __construct()
    {
        $this->usersGroups = new ArrayCollection();
        $this->userAddresses = new ArrayCollection();
        $this->parent = new ArrayCollection();
        $this->productReviews = new ArrayCollection();
        $this->wishlists = new ArrayCollection();
        $this->loyalties = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->senderNotis = new ArrayCollection();
        $this->receiverNotis = new ArrayCollection();
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

    /**
     * @return Collection<int, UserGroup>
     */
    public function getUsersGroups(): Collection
    {
        return $this->usersGroups;
    }

    public function addUsersGroup(UserGroup $usersGroup): static
    {
        if (!$this->usersGroups->contains($usersGroup)) {
            $this->usersGroups->add($usersGroup);
            $usersGroup->setUser($this);
        }

        return $this;
    }

    public function removeUsersGroup(UserGroup $usersGroup): static
    {
        if ($this->usersGroups->removeElement($usersGroup)) {
            // set the owning side to null (unless already changed)
            if ($usersGroup->getUser() === $this) {
                $usersGroup->setUser(null);
            }
        }

        return $this;
    }

    public function getUserProfiles(): ?UserProfile
    {
        return $this->userProfiles;
    }

    public function setUserProfiles(UserProfile $userProfiles): static
    {
        // set the owning side of the relation if necessary
        if ($userProfiles->getUser() !== $this) {
            $userProfiles->setUser($this);
        }

        $this->userProfiles = $userProfiles;

        return $this;
    }

    /**
     * @return Collection<int, UserAddress>
     */
    public function getUserAddresses(): Collection
    {
        return $this->userAddresses;
    }

    public function addUserAddress(UserAddress $userAddress): static
    {
        if (!$this->userAddresses->contains($userAddress)) {
            $this->userAddresses->add($userAddress);
            $userAddress->setUser($this);
        }

        return $this;
    }

    public function removeUserAddress(UserAddress $userAddress): static
    {
        if ($this->userAddresses->removeElement($userAddress)) {
            // set the owning side to null (unless already changed)
            if ($userAddress->getUser() === $this) {
                $userAddress->setUser(null);
            }
        }

        return $this;
    }

    public function getChildren(): ?self
    {
        return $this->children;
    }

    public function setChildren(?self $children): static
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): static
    {
        if (!$this->parent->contains($parent)) {
            $this->parent->add($parent);
            $parent->setChildren($this);
        }

        return $this;
    }

    public function removeParent(self $parent): static
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getChildren() === $this) {
                $parent->setChildren(null);
            }
        }

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
            $productReview->setUser($this);
        }

        return $this;
    }

    public function removeProductReview(ProductReview $productReview): static
    {
        if ($this->productReviews->removeElement($productReview)) {
            // set the owning side to null (unless already changed)
            if ($productReview->getUser() === $this) {
                $productReview->setUser(null);
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
            $wishlist->setUser($this);
        }

        return $this;
    }

    public function removeWishlist(Wishlist $wishlist): static
    {
        if ($this->wishlists->removeElement($wishlist)) {
            // set the owning side to null (unless already changed)
            if ($wishlist->getUser() === $this) {
                $wishlist->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Loyalty>
     */
    public function getLoyalties(): Collection
    {
        return $this->loyalties;
    }

    public function addLoyalty(Loyalty $loyalty): static
    {
        if (!$this->loyalties->contains($loyalty)) {
            $this->loyalties->add($loyalty);
            $loyalty->setUser($this);
        }

        return $this;
    }

    public function removeLoyalty(Loyalty $loyalty): static
    {
        if ($this->loyalties->removeElement($loyalty)) {
            // set the owning side to null (unless already changed)
            if ($loyalty->getUser() === $this) {
                $loyalty->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setUser($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getUser() === $this) {
                $contact->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getSenderNotis(): Collection
    {
        return $this->senderNotis;
    }

    public function addSenderNoti(Notification $senderNoti): static
    {
        if (!$this->senderNotis->contains($senderNoti)) {
            $this->senderNotis->add($senderNoti);
            $senderNoti->setSender($this);
        }

        return $this;
    }

    public function removeSenderNoti(Notification $senderNoti): static
    {
        if ($this->senderNotis->removeElement($senderNoti)) {
            // set the owning side to null (unless already changed)
            if ($senderNoti->getSender() === $this) {
                $senderNoti->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getReceiverNotis(): Collection
    {
        return $this->receiverNotis;
    }

    public function addReceiverNoti(Notification $receiverNoti): static
    {
        if (!$this->receiverNotis->contains($receiverNoti)) {
            $this->receiverNotis->add($receiverNoti);
            $receiverNoti->setReceiver($this);
        }

        return $this;
    }

    public function removeReceiverNoti(Notification $receiverNoti): static
    {
        if ($this->receiverNotis->removeElement($receiverNoti)) {
            // set the owning side to null (unless already changed)
            if ($receiverNoti->getReceiver() === $this) {
                $receiverNoti->setReceiver(null);
            }
        }

        return $this;
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

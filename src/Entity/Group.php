<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: 'groups')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'children', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private Collection $parent;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, UserGroup>
     */
    #[ORM\OneToMany(targetEntity: UserGroup::class, mappedBy: 'group_ref', orphanRemoval: true)]
    private Collection $usersGroups;
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent')]
    private ?self $children = null;

    public function __construct()
    {
        $this->usersGroups = new ArrayCollection();
        $this->parent = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
            $usersGroup->setGroupRef($this);
        }

        return $this;
    }

    public function removeUsersGroup(UserGroup $usersGroup): static
    {
        if ($this->usersGroups->removeElement($usersGroup)) {
            // set the owning side to null (unless already changed)
            if ($usersGroup->getGroupRef() === $this) {
                $usersGroup->setGroupRef(null);
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
}

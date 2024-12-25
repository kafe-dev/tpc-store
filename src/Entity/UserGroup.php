<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserGroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserGroupRepository::class)]
#[ORM\Table(name: 'users_groups')]
class UserGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist', 'remove'], inversedBy: 'usersGroups')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Group::class, cascade: ['persist', 'remove'], inversedBy: 'usersGroups')]
    #[ORM\JoinColumn(name: 'group_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Group $group_ref = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getGroupRef(): ?Group
    {
        return $this->group_ref;
    }

    public function setGroupRef(?Group $group_ref): static
    {
        $this->group_ref = $group_ref;

        return $this;
    }

}

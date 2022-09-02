<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\TeamMemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"search:team"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"})
 * @ORM\Entity(repositoryClass=TeamMemberRepository::class)
 */
class TeamMember
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"search:team"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="teamMembers", fetch="EAGER")
     * @Groups({"search:team"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="teamMembers", fetch="EAGER")
     */
    private $team;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_admin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_waiting;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_blocked;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_invite;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function isIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    public function isIsWaiting(): ?bool
    {
        return $this->is_waiting;
    }

    public function setIsWaiting(bool $is_waiting): self
    {
        $this->is_waiting = $is_waiting;

        return $this;
    }

    public function isIsBlocked(): ?bool
    {
        return $this->is_blocked;
    }

    public function setIsBlocked(bool $is_blocked): self
    {
        $this->is_blocked = $is_blocked;

        return $this;
    }

    public function isIsInvite(): ?bool
    {
        return $this->is_invite;
    }

    public function setIsInvite(bool $is_invite): self
    {
        $this->is_invite = $is_invite;

        return $this;
    }
}

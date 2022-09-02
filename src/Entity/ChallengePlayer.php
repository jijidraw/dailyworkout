<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChallengePlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChallengePlayerRepository::class)
 */
#[ApiResource]
class ChallengePlayer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="challengePlayers")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_invite;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_challenged;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_accomplish;

    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class, inversedBy="challengePlayers", fetch="EAGER")
     */
    private $challenge;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

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

    public function isIsInvite(): ?bool
    {
        return $this->is_invite;
    }

    public function setIsInvite(bool $is_invite): self
    {
        $this->is_invite = $is_invite;

        return $this;
    }

    public function isIsChallenged(): ?bool
    {
        return $this->is_challenged;
    }

    public function setIsChallenged(bool $is_challenged): self
    {
        $this->is_challenged = $is_challenged;

        return $this;
    }

    public function isIsAccomplish(): ?bool
    {
        return $this->is_accomplish;
    }

    public function setIsAccomplish(bool $is_accomplish): self
    {
        $this->is_accomplish = $is_accomplish;

        return $this;
    }

    public function getChallenge(): ?Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenge $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserMedalsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserMedalsRepository::class)
 */
#[ApiResource]
class UserMedals
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gold;

    /**
     * @ORM\Column(type="boolean")
     */
    private $silver;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bronze;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="userMedals", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isGold(): ?bool
    {
        return $this->gold;
    }

    public function setGold(bool $gold): self
    {
        $this->gold = $gold;

        return $this;
    }

    public function isSilver(): ?bool
    {
        return $this->silver;
    }

    public function setSilver(bool $silver): self
    {
        $this->silver = $silver;

        return $this;
    }

    public function isBronze(): ?bool
    {
        return $this->bronze;
    }

    public function setBronze(bool $bronze): self
    {
        $this->bronze = $bronze;

        return $this;
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
}

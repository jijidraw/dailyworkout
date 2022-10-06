<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserPreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserPreferenceRepository::class)
 */
#[ApiResource]
class UserPreference
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="userPreference", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_alcool;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_meditation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_tabac;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_healthy;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_training;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_weight;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_water;

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

    public function isIsAlcool(): ?bool
    {
        return $this->is_alcool;
    }

    public function setIsAlcool(bool $is_alcool): self
    {
        $this->is_alcool = $is_alcool;

        return $this;
    }

    public function isIsMeditation(): ?bool
    {
        return $this->is_meditation;
    }

    public function setIsMeditation(bool $is_meditation): self
    {
        $this->is_meditation = $is_meditation;

        return $this;
    }

    public function isIsTabac(): ?bool
    {
        return $this->is_tabac;
    }

    public function setIsTabac(bool $is_tabac): self
    {
        $this->is_tabac = $is_tabac;

        return $this;
    }

    public function isIsHealthy(): ?bool
    {
        return $this->is_healthy;
    }

    public function setIsHealthy(bool $is_healthy): self
    {
        $this->is_healthy = $is_healthy;

        return $this;
    }

    public function isIsTraining(): ?bool
    {
        return $this->is_training;
    }

    public function setIsTraining(bool $is_training): self
    {
        $this->is_training = $is_training;

        return $this;
    }

    public function isIsWeight(): ?bool
    {
        return $this->is_weight;
    }

    public function setIsWeight(bool $is_weight): self
    {
        $this->is_weight = $is_weight;

        return $this;
    }

    public function isIsWater(): ?bool
    {
        return $this->is_water;
    }

    public function setIsWater(bool $is_water): self
    {
        $this->is_water = $is_water;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\DifficultyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource (
 * normalizationContext={"groups"={"workout:display"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=DifficultyRepository::class)
 */
class Difficulty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"workout:display"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Workout::class, mappedBy="level")
     */
    private $workout;

    /**
     * @ORM\OneToMany(targetEntity=Challenge::class, mappedBy="level")
     */
    private $challenge;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->workout = new ArrayCollection();
        $this->challenge = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Workout>
     */
    public function getWorkout(): Collection
    {
        return $this->workout;
    }

    public function addWorkout(Workout $workout): self
    {
        if (!$this->workout->contains($workout)) {
            $this->workout[] = $workout;
            $workout->setLevel($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): self
    {
        if ($this->workout->removeElement($workout)) {
            // set the owning side to null (unless already changed)
            if ($workout->getLevel() === $this) {
                $workout->setLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Challenge>
     */
    public function getChallenge(): Collection
    {
        return $this->challenge;
    }

    public function addChallenge(Challenge $challenge): self
    {
        if (!$this->challenge->contains($challenge)) {
            $this->challenge[] = $challenge;
            $challenge->setLevel($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenge->removeElement($challenge)) {
            // set the owning side to null (unless already changed)
            if ($challenge->getLevel() === $this) {
                $challenge->setLevel(null);
            }
        }

        return $this;
    }
}

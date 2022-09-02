<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\MuscleGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=MuscleGroupRepository::class)
 */
class MuscleGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Exercice::class, mappedBy="muscleGroup")
     */
    private $exercices;

    /**
     * @ORM\ManyToMany(targetEntity=Workout::class, mappedBy="muscleGroup")
     */
    private $workouts;

    /**
     * @ORM\OneToOne(targetEntity=Images::class, cascade={"persist", "remove"})
     */
    private $image;

    public function __construct()
    {
        $this->exercices = new ArrayCollection();
        $this->workouts = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->name;
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
     * @return Collection<int, Exercice>
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
            $exercice->addMuscleGroup($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): self
    {
        if ($this->exercices->removeElement($exercice)) {
            $exercice->removeMuscleGroup($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Workout>
     */
    public function getWorkouts(): Collection
    {
        return $this->workouts;
    }

    public function addWorkout(Workout $workout): self
    {
        if (!$this->workouts->contains($workout)) {
            $this->workouts[] = $workout;
            $workout->addMuscleGroup($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): self
    {
        if ($this->workouts->removeElement($workout)) {
            $workout->removeMuscleGroup($this);
        }

        return $this;
    }

    public function getImage(): ?Images
    {
        return $this->image;
    }

    public function setImage(?Images $image): self
    {
        $this->image = $image;

        return $this;
    }
}

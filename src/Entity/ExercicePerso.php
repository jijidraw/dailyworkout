<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ExercicePersoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ExercicePersoRepository::class)
 */
class ExercicePerso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"workout:display"})
     * 
     */
    private $id;

    /**
     * @Groups({"workout:display"})
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @Groups({"workout:display"})
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    /**
     * @Groups({"workout:display"})
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Rest;

    /**
     * @Groups({"workout:display"})
     * 
     * @ORM\ManyToOne(targetEntity=Workout::class, inversedBy="exercicePersos")
     */
    private $workout;

    /**
     * @Groups({"workout:display"})
     * @ORM\ManyToOne(targetEntity=Exercice::class, inversedBy="exercicePersos", fetch="EAGER")
     */
    private $exercice;

    /**
     * @Groups({"workout:display"})
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $EffortType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRest(): ?string
    {
        return $this->Rest;
    }

    public function setRest(string $Rest): self
    {
        $this->Rest = $Rest;

        return $this;
    }

    public function getWorkout(): ?Workout
    {
        return $this->workout;
    }

    public function setWorkout(?Workout $workout): self
    {
        $this->workout = $workout;

        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getEffortType(): ?string
    {
        return $this->EffortType;
    }

    public function setEffortType(string $EffortType): self
    {
        $this->EffortType = $EffortType;

        return $this;
    }
}

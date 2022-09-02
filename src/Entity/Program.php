<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgramRepository::class)
 * @ApiResource()
 * 
 */
class Program
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="programs")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=workout::class, mappedBy="program")
     */
    private $workout;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $scheduled_date;

    public function __construct()
    {
        $this->workout = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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

    /**
     * @return Collection<int, workout>
     */
    public function getWorkout(): Collection
    {
        return $this->workout;
    }

    public function addWorkout(workout $workout): self
    {
        if (!$this->workout->contains($workout)) {
            $this->workout[] = $workout;
            $workout->setProgram($this);
        }

        return $this;
    }

    public function removeWorkout(workout $workout): self
    {
        if ($this->workout->removeElement($workout)) {
            // set the owning side to null (unless already changed)
            if ($workout->getProgram() === $this) {
                $workout->setProgram(null);
            }
        }

        return $this;
    }

    public function getScheduledDate(): ?\DateTimeInterface
    {
        return $this->scheduled_date;
    }

    public function setScheduledDate(?\DateTimeInterface $scheduled_date): self
    {
        $this->scheduled_date = $scheduled_date;

        return $this;
    }
}

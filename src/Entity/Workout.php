<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"workout:display"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=WorkoutRepository::class)
 */
class Workout
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"workout:display"})
     */
    private $id;

    /**
     * @Groups({"workout:display"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @Groups({"workout:display"})
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $rounds;

    /**
     * @Groups({"workout:display"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @Groups({"workout:display"})
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @Groups({"workout:display"})
     * @ORM\OneToMany(targetEntity=ExercicePerso::class, mappedBy="workout", orphanRemoval=true, cascade={"persist"}, fetch="EAGER")
     */
    private $exercicePersos;

    /**
     * @Groups({"workout:display"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="workouts")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Program::class, inversedBy="workout")
     */
    private $program;

    /**
     * @ORM\OneToMany(targetEntity=Week::class, mappedBy="workout", cascade={"persist", "remove"})
     */
    private $weeks;

    /**
     * @Groups({"workout:display"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $difficulty;

    /**
     * @Groups({"workout:display"})
     * @ORM\OneToMany(targetEntity=WorkoutFav::class, mappedBy="workout", cascade={"persist", "remove"})
     */
    private $workoutFavs;

    /**
     * @Groups({"workout:display"})
     * @ORM\ManyToMany(targetEntity=MuscleGroup::class, inversedBy="workouts")
     */
    private $muscleGroup;

    /**
     * @ORM\OneToMany(targetEntity=Challenge::class, mappedBy="workout", cascade={"persist", "remove"})
     */
    private $challenges;

    /**
     * @ORM\OneToMany(targetEntity=WorkoutNotation::class, mappedBy="workout")
     */
    private $workoutNotations;

    /**
     * @Groups({"workout:display"})
     * @ORM\ManyToOne(targetEntity=Difficulty::class, inversedBy="workout", fetch="EAGER")
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity=SportsList::class, inversedBy="workout")
     */
    private $sport;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->exercicePersos = new ArrayCollection();
        $this->weeks = new ArrayCollection();
        $this->workoutFavs = new ArrayCollection();
        $this->muscleGroup = new ArrayCollection();
        $this->challenges = new ArrayCollection();
        $this->workoutNotations = new ArrayCollection();
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

    public function getRounds(): ?string
    {
        return $this->rounds;
    }

    public function setRounds(string $rounds): self
    {
        $this->rounds = $rounds;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, ExercicePerso>
     */
    public function getExercicePersos(): Collection
    {
        return $this->exercicePersos;
    }

    public function addExercicePerso(ExercicePerso $exercicePerso): self
    {
        if (!$this->exercicePersos->contains($exercicePerso)) {
            $this->exercicePersos[] = $exercicePerso;
            $exercicePerso->setWorkout($this);
        }

        return $this;
    }

    public function removeExercicePerso(ExercicePerso $exercicePerso): self
    {
        if ($this->exercicePersos->removeElement($exercicePerso)) {
            // set the owning side to null (unless already changed)
            if ($exercicePerso->getWorkout() === $this) {
                $exercicePerso->setWorkout(null);
            }
        }

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

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

        return $this;
    }

    /**
     * @return Collection<int, Week>
     */
    public function getWeeks(): Collection
    {
        return $this->weeks;
    }

    public function addWeek(Week $week): self
    {
        if (!$this->weeks->contains($week)) {
            $this->weeks[] = $week;
            $week->setWorkout($this);
        }

        return $this;
    }

    public function removeWeek(Week $week): self
    {
        if ($this->weeks->removeElement($week)) {
            // set the owning side to null (unless already changed)
            if ($week->getWorkout() === $this) {
                $week->setWorkout(null);
            }
        }

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return Collection<int, WorkoutFav>
     */
    public function getWorkoutFavs(): Collection
    {
        return $this->workoutFavs;
    }

    public function addWorkoutFav(WorkoutFav $workoutFav): self
    {
        if (!$this->workoutFavs->contains($workoutFav)) {
            $this->workoutFavs[] = $workoutFav;
            $workoutFav->setWorkout($this);
        }

        return $this;
    }

    public function removeWorkoutFav(WorkoutFav $workoutFav): self
    {
        if ($this->workoutFavs->removeElement($workoutFav)) {
            // set the owning side to null (unless already changed)
            if ($workoutFav->getWorkout() === $this) {
                $workoutFav->setWorkout(null);
            }
        }

        return $this;
    }
    public function isFavsByUser(User $user): bool
    {
        foreach ($this->workoutFavs as $workoutFav) {
            if ($workoutFav->getUser() === $user) return true;
        }
        return false;
    }

    /**
     * @return Collection<int, MuscleGroup>
     */
    public function getMuscleGroup(): Collection
    {
        return $this->muscleGroup;
    }

    public function addMuscleGroup(MuscleGroup $muscleGroup): self
    {
        if (!$this->muscleGroup->contains($muscleGroup)) {
            $this->muscleGroup[] = $muscleGroup;
        }

        return $this;
    }

    public function removeMuscleGroup(MuscleGroup $muscleGroup): self
    {
        $this->muscleGroup->removeElement($muscleGroup);

        return $this;
    }

    /**
     * @return Collection<int, Challenge>
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function addChallenge(Challenge $challenge): self
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges[] = $challenge;
            $challenge->setWorkout($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenges->removeElement($challenge)) {
            // set the owning side to null (unless already changed)
            if ($challenge->getWorkout() === $this) {
                $challenge->setWorkout(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WorkoutNotation>
     */
    public function getWorkoutNotations(): Collection
    {
        return $this->workoutNotations;
    }

    public function addWorkoutNotation(WorkoutNotation $workoutNotation): self
    {
        if (!$this->workoutNotations->contains($workoutNotation)) {
            $this->workoutNotations[] = $workoutNotation;
            $workoutNotation->setWorkout($this);
        }

        return $this;
    }

    public function removeWorkoutNotation(WorkoutNotation $workoutNotation): self
    {
        if ($this->workoutNotations->removeElement($workoutNotation)) {
            // set the owning side to null (unless already changed)
            if ($workoutNotation->getWorkout() === $this) {
                $workoutNotation->setWorkout(null);
            }
        }

        return $this;
    }

    public function getLevel(): ?Difficulty
    {
        return $this->level;
    }

    public function setLevel(?Difficulty $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getSport(): ?SportsList
    {
        return $this->sport;
    }

    public function setSport(?SportsList $sport): self
    {
        $this->sport = $sport;

        return $this;
    }
}

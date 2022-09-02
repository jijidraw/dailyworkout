<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SportsListRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SportsListRepository::class)
 */
class SportsList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("sports:list") 
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("sports:list") 
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Equipment::class, mappedBy="SportList")
     */
    private $equipment;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="sportlist")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="sport")
     */
    private $teams;

    /**
     * @ORM\OneToOne(targetEntity=ImageSystem::class, mappedBy="sport", cascade={"persist", "remove"})
     */
    private $imageSystem;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_solo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_group;

    /**
     * @ORM\ManyToMany(targetEntity=Workout::class, mappedBy="sport")
     */
    private $workouts;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->equipment = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->workouts = new ArrayCollection();
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
     * @return Collection<int, Equipment>
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment[] = $equipment;
            $equipment->addSportList($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->removeElement($equipment)) {
            $equipment->removeSportList($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addSportlist($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeSportlist($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setSport($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getSport() === $this) {
                $team->setSport(null);
            }
        }

        return $this;
    }

    public function getImageSystem(): ?ImageSystem
    {
        return $this->imageSystem;
    }

    public function setImageSystem(?ImageSystem $imageSystem): self
    {
        // unset the owning side of the relation if necessary
        if ($imageSystem === null && $this->imageSystem !== null) {
            $this->imageSystem->setSport(null);
        }

        // set the owning side of the relation if necessary
        if ($imageSystem !== null && $imageSystem->getSport() !== $this) {
            $imageSystem->setSport($this);
        }

        $this->imageSystem = $imageSystem;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsSolo(): ?bool
    {
        return $this->is_solo;
    }

    public function setIsSolo(bool $is_solo): self
    {
        $this->is_solo = $is_solo;

        return $this;
    }

    public function isIsGroup(): ?bool
    {
        return $this->is_group;
    }

    public function setIsGroup(bool $is_group): self
    {
        $this->is_group = $is_group;

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
            $workout->addSport($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): self
    {
        if ($this->workouts->removeElement($workout)) {
            $workout->removeSport($this);
        }

        return $this;
    }
}

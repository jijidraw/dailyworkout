<?php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"workout:display"}, {"exercice:detail"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=ExerciceRepository::class)
 */
class Exercice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("exercice:category")
     * @Groups("exercice:detail")
     * @Groups("exercice:display")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"exercice:category"})
     * @Groups({"workout:display"})
     * @Groups({"exercice:detail"})
     * @Groups({"exercice:display"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlvideo;

    /**
     * @ORM\OneToMany(targetEntity=ExercicePerso::class, mappedBy="exercice")
     */
    private $exercicePersos;

    /**
     * @ORM\ManyToMany(targetEntity=MuscleGroup::class, inversedBy="exercices")
     * @Groups("exercice:category", "workout:display")
     * @Groups({"exercice:detail"})
     * 
     */
    private $muscleGroup;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="exercice")
     * @Groups("exercice:category", "workout:display")
     * @Groups({"exercice:detail"})
     * 
     */
    private $categories;

    /**
     * @ORM\OneToOne(targetEntity=ImageSystem::class, mappedBy="exercice", cascade={"persist", "remove"})
     * @Groups("exercice:category", "workout:display")
     * @Groups({"workout:display"})
     * @Groups({"exercice:detail"})
     * @Groups({"exercice:display"})
     */
    private $imageSystem;

    /**
     * @ORM\ManyToMany(targetEntity=SportsList::class, inversedBy="exercices")
     */
    private $sports;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->exercicePersos = new ArrayCollection();
        $this->muscleGroup = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->sports = new ArrayCollection();
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

    public function getUrlvideo(): ?string
    {
        return $this->urlvideo;
    }

    public function setUrlvideo(?string $urlvideo): self
    {
        $this->urlvideo = $urlvideo;

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
            $exercicePerso->setExercice($this);
        }

        return $this;
    }

    public function removeExercicePerso(ExercicePerso $exercicePerso): self
    {
        if ($this->exercicePersos->removeElement($exercicePerso)) {
            // set the owning side to null (unless already changed)
            if ($exercicePerso->getExercice() === $this) {
                $exercicePerso->setExercice(null);
            }
        }

        return $this;
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
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addExercice($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeExercice($this);
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
            $this->imageSystem->setExercice(null);
        }

        // set the owning side of the relation if necessary
        if ($imageSystem !== null && $imageSystem->getExercice() !== $this) {
            $imageSystem->setExercice($this);
        }

        $this->imageSystem = $imageSystem;

        return $this;
    }

    /**
     * @return Collection<int, SportsList>
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(SportsList $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
        }

        return $this;
    }

    public function removeSport(SportsList $sport): self
    {
        $this->sports->removeElement($sport);

        return $this;
    }
}

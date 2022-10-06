<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DiaryNoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiaryNoteRepository::class)
 */
#[ApiResource]
class DiaryNote
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weight;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="diaryNotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cheatmeal;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $alcool;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $training;

    /**
     * @ORM\OneToOne(targetEntity=Images::class, mappedBy="diary", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tabac;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_meditation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_water;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $month;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $year;

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

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isCheatmeal(): ?bool
    {
        return $this->cheatmeal;
    }

    public function setCheatmeal(bool $cheatmeal): self
    {
        $this->cheatmeal = $cheatmeal;

        return $this;
    }

    public function isAlcool(): ?bool
    {
        return $this->alcool;
    }

    public function setAlcool(bool $alcool): self
    {
        $this->alcool = $alcool;

        return $this;
    }

    public function isTraining(): ?bool
    {
        return $this->training;
    }

    public function setTraining(bool $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getImages(): ?Images
    {
        return $this->images;
    }

    public function setImages(?Images $images): self
    {
        // unset the owning side of the relation if necessary
        if ($images === null && $this->images !== null) {
            $this->images->setDiary(null);
        }

        // set the owning side of the relation if necessary
        if ($images !== null && $images->getDiary() !== $this) {
            $images->setDiary($this);
        }

        $this->images = $images;

        return $this;
    }

    public function getTabac(): ?int
    {
        return $this->tabac;
    }

    public function setTabac(?int $tabac): self
    {
        $this->tabac = $tabac;

        return $this;
    }

    public function isIsMeditation(): ?bool
    {
        return $this->is_meditation;
    }

    public function setIsMeditation(?bool $is_meditation): self
    {
        $this->is_meditation = $is_meditation;

        return $this;
    }

    public function isIsWater(): ?bool
    {
        return $this->is_water;
    }

    public function setIsWater(?bool $is_water): self
    {
        $this->is_water = $is_water;

        return $this;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(?string $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

        return $this;
    }
}

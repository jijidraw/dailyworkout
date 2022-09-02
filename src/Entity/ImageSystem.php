<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ImageSystemRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ImageSystemRepository::class)
 */
class ImageSystem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("exercice:category", "workout:display")
     * @Groups({"workout:display"})
     * @Groups({"exercice:detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("exercice:category", "workout:display")
     * @Groups({"workout:display"})
     * @Groups({"exercice:detail"})
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Exercice::class, inversedBy="imageSystem", cascade={"persist"})
     */
    private $exercice;

    /**
     * @ORM\OneToOne(targetEntity=Equipment::class, inversedBy="imageSystem", cascade={"persist"})
     */
    private $equipment;

    /**
     * @ORM\OneToOne(targetEntity=SportsList::class, inversedBy="imageSystem", cascade={"persist"})
     */
    private $sport;

    /**
     * @ORM\OneToOne(targetEntity=Reward::class, inversedBy="imageSystem", cascade={"persist", "remove"})
     */
    private $reward;

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

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

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

    public function getReward(): ?Reward
    {
        return $this->reward;
    }

    public function setReward(?Reward $reward): self
    {
        $this->reward = $reward;

        return $this;
    }
}

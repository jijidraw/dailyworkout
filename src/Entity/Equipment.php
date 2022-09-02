<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 */
class Equipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=SportsList::class, inversedBy="equipment")
     */
    private $SportList;

    /**
     * @ORM\OneToOne(targetEntity=ImageSystem::class, mappedBy="equipment", cascade={"persist", "remove"})
     */
    private $imageSystem;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=UserNotice::class, mappedBy="equipment")
     */
    private $userNotices;

    /**
     * @ORM\ManyToMany(targetEntity=EquipmentCategory::class, inversedBy="equipment")
     */
    private $equipmentCategorys;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->SportList = new ArrayCollection();
        $this->userNotices = new ArrayCollection();
        $this->equipmentCategorys = new ArrayCollection();
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
     * @return Collection<int, SportsList>
     */
    public function getSportList(): Collection
    {
        return $this->SportList;
    }

    public function addSportList(SportsList $sportList): self
    {
        if (!$this->SportList->contains($sportList)) {
            $this->SportList[] = $sportList;
        }

        return $this;
    }

    public function removeSportList(SportsList $sportList): self
    {
        $this->SportList->removeElement($sportList);

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
            $this->imageSystem->setEquipment(null);
        }

        // set the owning side of the relation if necessary
        if ($imageSystem !== null && $imageSystem->getEquipment() !== $this) {
            $imageSystem->setEquipment($this);
        }

        $this->imageSystem = $imageSystem;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, UserNotice>
     */
    public function getUserNotices(): Collection
    {
        return $this->userNotices;
    }

    public function addUserNotice(UserNotice $userNotice): self
    {
        if (!$this->userNotices->contains($userNotice)) {
            $this->userNotices[] = $userNotice;
            $userNotice->setEquipment($this);
        }

        return $this;
    }

    public function removeUserNotice(UserNotice $userNotice): self
    {
        if ($this->userNotices->removeElement($userNotice)) {
            // set the owning side to null (unless already changed)
            if ($userNotice->getEquipment() === $this) {
                $userNotice->setEquipment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EquipmentCategory>
     */
    public function getEquipmentCategorys(): Collection
    {
        return $this->equipmentCategorys;
    }

    public function addEquipmentCategory(EquipmentCategory $equipmentCategory): self
    {
        if (!$this->equipmentCategorys->contains($equipmentCategory)) {
            $this->equipmentCategorys[] = $equipmentCategory;
        }

        return $this;
    }

    public function removeEquipmentCategory(EquipmentCategory $equipmentCategory): self
    {
        $this->equipmentCategorys->removeElement($equipmentCategory);

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }
}

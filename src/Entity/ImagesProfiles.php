<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ImagesProfilesRepository;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"user:link"}, {"read:comment"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=ImagesProfilesRepository::class)
 */
class ImagesProfiles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:comment", "read:message", "user:link"})
     * @Groups({"workout:display"})
     * @Groups({"search:team"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:comment", "read:message", "user:link"})
     * @Groups({"workout:display"})
     * @Groups({"search:team"})
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="imagesProfiles", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Team::class, inversedBy="imagesProfiles", cascade={"persist"})
     */
    private $team;

    /**
     * @ORM\OneToOne(targetEntity=Event::class, inversedBy="imagesProfiles", cascade={"persist", "remove"})
     */
    private $event;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}

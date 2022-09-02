<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"search:team"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"search:team"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"search:team"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"search:team"})
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=TeamPost::class, mappedBy="team")
     */
    private $teamPosts;

    /**
     * @ORM\ManyToOne(targetEntity=SportsList::class, inversedBy="teams", fetch="EAGER")
     * @Groups({"search:team"})
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity=TeamMember::class, mappedBy="team", cascade={"persist"})
     * @Groups({"search:team"})
     */
    private $teamMembers;

    /**
     * @ORM\OneToOne(targetEntity=ImagesProfiles::class, mappedBy="team", cascade={"persist", "remove"})
     * @Groups({"search:team"})
     */
    private $imagesProfiles;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="team")
     */
    private $notifications;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_private;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->teamPosts = new ArrayCollection();
        $this->teamMembers = new ArrayCollection();
        $this->notifications = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
     * @return Collection<int, TeamPost>
     */
    public function getTeamPosts(): Collection
    {
        return $this->teamPosts;
    }

    public function addTeamPost(TeamPost $teamPost): self
    {
        if (!$this->teamPosts->contains($teamPost)) {
            $this->teamPosts[] = $teamPost;
            $teamPost->setTeam($this);
        }

        return $this;
    }

    public function removeTeamPost(TeamPost $teamPost): self
    {
        if ($this->teamPosts->removeElement($teamPost)) {
            // set the owning side to null (unless already changed)
            if ($teamPost->getTeam() === $this) {
                $teamPost->setTeam(null);
            }
        }

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

    /**
     * @return Collection<int, TeamMember>
     */
    public function getTeamMembers(): Collection
    {
        return $this->teamMembers;
    }

    public function addTeamMember(TeamMember $teamMember): self
    {
        if (!$this->teamMembers->contains($teamMember)) {
            $this->teamMembers[] = $teamMember;
            $teamMember->setTeam($this);
        }

        return $this;
    }

    public function removeTeamMember(TeamMember $teamMember): self
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            // set the owning side to null (unless already changed)
            if ($teamMember->getTeam() === $this) {
                $teamMember->setTeam(null);
            }
        }

        return $this;
    }

    public function getImagesProfiles(): ?ImagesProfiles
    {
        return $this->imagesProfiles;
    }

    public function setImagesProfiles(?ImagesProfiles $imagesProfiles): self
    {
        // unset the owning side of the relation if necessary
        if ($imagesProfiles === null && $this->imagesProfiles !== null) {
            $this->imagesProfiles->setTeam(null);
        }

        // set the owning side of the relation if necessary
        if ($imagesProfiles !== null && $imagesProfiles->getTeam() !== $this) {
            $imagesProfiles->setTeam($this);
        }

        $this->imagesProfiles = $imagesProfiles;

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setTeam($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getTeam() === $this) {
                $notification->setTeam(null);
            }
        }

        return $this;
    }

    public function isIsPrivate(): ?bool
    {
        return $this->is_private;
    }

    public function setIsPrivate(bool $is_private): self
    {
        $this->is_private = $is_private;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}

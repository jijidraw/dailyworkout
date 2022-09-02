<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=ChallengeRepository::class)
 */
#[ApiResource]
class Challenge
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Workout::class, inversedBy="challenges", fetch="EAGER")
     */
    private $workout;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $youtubeLink;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="challenges")
     */
    private $creatorChallenge;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="challenge")
     */
    private $notifications;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity=Images::class, mappedBy="challenge", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=ChallengePlayer::class, mappedBy="challenge")
     */
    private $challengePlayers;

    /**
     * @ORM\OneToMany(targetEntity=ChallengeComment::class, mappedBy="challenge", orphanRemoval=true)
     */
    private $challengeComments;

    /**
     * @ORM\ManyToOne(targetEntity=Difficulty::class, inversedBy="challenge", fetch="EAGER")
     */
    private $level;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_public;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->notifications = new ArrayCollection();
        $this->challengePlayers = new ArrayCollection();
        $this->challengeComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->youtubeLink;
    }

    public function setYoutubeLink(?string $youtubeLink): self
    {
        $this->youtubeLink = $youtubeLink;

        return $this;
    }

    public function getCreatorChallenge(): ?User
    {
        return $this->creatorChallenge;
    }

    public function setCreatorChallenge(?User $creatorChallenge): self
    {
        $this->creatorChallenge = $creatorChallenge;

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
            $notification->setChallenge($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getChallenge() === $this) {
                $notification->setChallenge(null);
            }
        }

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

    public function getImages(): ?Images
    {
        return $this->images;
    }

    public function setImages(?Images $images): self
    {
        // unset the owning side of the relation if necessary
        if ($images === null && $this->images !== null) {
            $this->images->setChallenge(null);
        }

        // set the owning side of the relation if necessary
        if ($images !== null && $images->getChallenge() !== $this) {
            $images->setChallenge($this);
        }

        $this->images = $images;

        return $this;
    }

    /**
     * @return Collection<int, ChallengePlayer>
     */
    public function getChallengePlayers(): Collection
    {
        return $this->challengePlayers;
    }

    public function addChallengePlayer(ChallengePlayer $challengePlayer): self
    {
        if (!$this->challengePlayers->contains($challengePlayer)) {
            $this->challengePlayers[] = $challengePlayer;
            $challengePlayer->setChallenge($this);
        }

        return $this;
    }

    public function removeChallengePlayer(ChallengePlayer $challengePlayer): self
    {
        if ($this->challengePlayers->removeElement($challengePlayer)) {
            // set the owning side to null (unless already changed)
            if ($challengePlayer->getChallenge() === $this) {
                $challengePlayer->setChallenge(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChallengeComment>
     */
    public function getChallengeComments(): Collection
    {
        return $this->challengeComments;
    }

    public function addChallengeComment(ChallengeComment $challengeComment): self
    {
        if (!$this->challengeComments->contains($challengeComment)) {
            $this->challengeComments[] = $challengeComment;
            $challengeComment->setChallenge($this);
        }

        return $this;
    }

    public function removeChallengeComment(ChallengeComment $challengeComment): self
    {
        if ($this->challengeComments->removeElement($challengeComment)) {
            // set the owning side to null (unless already changed)
            if ($challengeComment->getChallenge() === $this) {
                $challengeComment->setChallenge(null);
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

    public function isIsPublic(): ?bool
    {
        return $this->is_public;
    }

    public function setIsPublic(bool $is_public): self
    {
        $this->is_public = $is_public;

        return $this;
    }
}

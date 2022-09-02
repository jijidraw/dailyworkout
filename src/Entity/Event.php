<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
#[ApiResource]
class Event
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
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="datetime")
     */
    private $eventDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\OneToOne(targetEntity=ImagesProfiles::class, mappedBy="event", cascade={"persist"})
     */
    private $imagesProfiles;

    /**
     * @ORM\OneToMany(targetEntity=PostEvent::class, mappedBy="event")
     */
    private $postEvents;

    /**
     * @ORM\OneToMany(targetEntity=EventParticipate::class, mappedBy="event")
     */
    private $eventParticipates;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->postEvents = new ArrayCollection();
        $this->eventParticipates = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

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

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

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

    public function getImagesProfiles(): ?ImagesProfiles
    {
        return $this->imagesProfiles;
    }

    public function setImagesProfiles(?ImagesProfiles $imagesProfiles): self
    {
        // unset the owning side of the relation if necessary
        if ($imagesProfiles === null && $this->imagesProfiles !== null) {
            $this->imagesProfiles->setEvent(null);
        }

        // set the owning side of the relation if necessary
        if ($imagesProfiles !== null && $imagesProfiles->getEvent() !== $this) {
            $imagesProfiles->setEvent($this);
        }

        $this->imagesProfiles = $imagesProfiles;

        return $this;
    }

    /**
     * @return Collection<int, PostEvent>
     */
    public function getPostEvents(): Collection
    {
        return $this->postEvents;
    }

    public function addPostEvent(PostEvent $postEvent): self
    {
        if (!$this->postEvents->contains($postEvent)) {
            $this->postEvents[] = $postEvent;
            $postEvent->setEvent($this);
        }

        return $this;
    }

    public function removePostEvent(PostEvent $postEvent): self
    {
        if ($this->postEvents->removeElement($postEvent)) {
            // set the owning side to null (unless already changed)
            if ($postEvent->getEvent() === $this) {
                $postEvent->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EventParticipate>
     */
    public function getEventParticipates(): Collection
    {
        return $this->eventParticipates;
    }

    public function addEventParticipate(EventParticipate $eventParticipate): self
    {
        if (!$this->eventParticipates->contains($eventParticipate)) {
            $this->eventParticipates[] = $eventParticipate;
            $eventParticipate->setEvent($this);
        }

        return $this;
    }

    public function removeEventParticipate(EventParticipate $eventParticipate): self
    {
        if ($this->eventParticipates->removeElement($eventParticipate)) {
            // set the owning side to null (unless already changed)
            if ($eventParticipate->getEvent() === $this) {
                $eventParticipate->setEvent(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ConversationRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"read:message"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"}
 * )
 */
class Conversation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:message"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="conversation")
     */
    private $messages;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userA", fetch="EAGER")
     */
    private $userA;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userB", fetch="EAGER")
     */
    private $userB;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setConversation($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getConversation() === $this) {
                $message->setConversation(null);
            }
        }

        return $this;
    }

    public function getUserA(): ?User
    {
        return $this->userA;
    }

    public function setUserA(?User $userA): self
    {
        $this->userA = $userA;

        return $this;
    }

    public function getUserB(): ?User
    {
        return $this->userB;
    }

    public function setUserB(?User $userB): self
    {
        $this->userB = $userB;

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

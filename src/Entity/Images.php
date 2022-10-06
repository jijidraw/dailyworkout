<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"exercice:category"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("exercice:category") 
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("exercice:category", "sports:list") 
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="images")
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=PostEvent::class, inversedBy="images")
     */
    private $event;

    /**
     * @ORM\OneToOne(targetEntity=TeamPost::class, mappedBy="image", cascade={"persist", "remove"})
     */
    private $teamPost;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="image")
     */
    private $article;

    /**
     * @ORM\OneToOne(targetEntity=Challenge::class, inversedBy="images", cascade={"persist", "remove"})
     */
    private $challenge;

    /**
     * @ORM\OneToOne(targetEntity=DiaryNote::class, inversedBy="images", cascade={"persist", "remove"})
     */
    private $diary;

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

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?PostEvent $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getTeamPost(): ?TeamPost
    {
        return $this->teamPost;
    }

    public function setTeamPost(?TeamPost $teamPost): self
    {
        // unset the owning side of the relation if necessary
        if ($teamPost === null && $this->teamPost !== null) {
            $this->teamPost->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($teamPost !== null && $teamPost->getImage() !== $this) {
            $teamPost->setImage($this);
        }

        $this->teamPost = $teamPost;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getChallenge(): ?Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenge $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getDiary(): ?DiaryNote
    {
        return $this->diary;
    }

    public function setDiary(?DiaryNote $diary): self
    {
        $this->diary = $diary;

        return $this;
    }
}

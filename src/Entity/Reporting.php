<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReportingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=ReportingRepository::class)
 */
class Reporting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class)
     */
    private $privateMessage;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class)
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class)
     */
    private $challenge;

    /**
     * @ORM\ManyToOne(targetEntity=ChallengeComment::class)
     */
    private $challengeComment;

    /**
     * @ORM\ManyToOne(targetEntity=Comment::class)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $userReported;

    /**
     * @ORM\Column(type="datetime")
     */
    private $reported_at;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrivateMessage(): ?Message
    {
        return $this->privateMessage;
    }

    public function setPrivateMessage(?Message $privateMessage): self
    {
        $this->privateMessage = $privateMessage;

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

    public function getChallenge(): ?Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenge $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getChallengeComment(): ?ChallengeComment
    {
        return $this->challengeComment;
    }

    public function setChallengeComment(?ChallengeComment $challengeComment): self
    {
        $this->challengeComment = $challengeComment;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

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

    public function getUserReported(): ?User
    {
        return $this->userReported;
    }

    public function setUserReported(?User $userReported): self
    {
        $this->userReported = $userReported;

        return $this;
    }

    public function getReportedAt(): ?\DateTimeInterface
    {
        return $this->reported_at;
    }

    public function setReportedAt(\DateTimeInterface $reported_at): self
    {
        $this->reported_at = $reported_at;

        return $this;
    }
}

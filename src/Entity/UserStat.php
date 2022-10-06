<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserStatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserStatRepository::class)
 */
#[ApiResource]
class UserStat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $post;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $workout;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $challenge;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $trophy;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $follower;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $following;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sport;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $challengeAccepted;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $challengeAccomplish;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $teamCreate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $teamMember;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $points;

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

    public function getPost(): ?int
    {
        return $this->post;
    }

    public function setPost(?int $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getComment(): ?int
    {
        return $this->comment;
    }

    public function setComment(?int $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getWorkout(): ?int
    {
        return $this->workout;
    }

    public function setWorkout(?int $workout): self
    {
        $this->workout = $workout;

        return $this;
    }

    public function getChallenge(): ?int
    {
        return $this->challenge;
    }

    public function setChallenge(?int $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getTrophy(): ?int
    {
        return $this->trophy;
    }

    public function setTrophy(?int $trophy): self
    {
        $this->trophy = $trophy;

        return $this;
    }

    public function getFollower(): ?int
    {
        return $this->follower;
    }

    public function setFollower(?int $follower): self
    {
        $this->follower = $follower;

        return $this;
    }

    public function getFollowing(): ?int
    {
        return $this->following;
    }

    public function setFollowing(?int $following): self
    {
        $this->following = $following;

        return $this;
    }

    public function getSport(): ?int
    {
        return $this->sport;
    }

    public function setSport(?int $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getChallengeAccepted(): ?int
    {
        return $this->challengeAccepted;
    }

    public function setChallengeAccepted(?int $challengeAccepted): self
    {
        $this->challengeAccepted = $challengeAccepted;

        return $this;
    }

    public function getChallengeAccomplish(): ?int
    {
        return $this->challengeAccomplish;
    }

    public function setChallengeAccomplish(?int $challengeAccomplish): self
    {
        $this->challengeAccomplish = $challengeAccomplish;

        return $this;
    }

    public function getTeamCreate(): ?int
    {
        return $this->teamCreate;
    }

    public function setTeamCreate(?int $teamCreate): self
    {
        $this->teamCreate = $teamCreate;

        return $this;
    }

    public function getTeamMember(): ?int
    {
        return $this->teamMember;
    }

    public function setTeamMember(?int $teamMember): self
    {
        $this->teamMember = $teamMember;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }
}

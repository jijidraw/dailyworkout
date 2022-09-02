<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\FollowRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"user:link"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=FollowRepository::class)
 */
class Follow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:link"})
     * 
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="follower", fetch="EAGER")
     * @Groups({"user:link"})
     */
    private $follower;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="following", fetch="EAGER")
     * @Groups({"user:link"})
     */
    private $following;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollower(): ?User
    {
        return $this->follower;
    }

    public function setFollower(?User $follower): self
    {
        $this->follower = $follower;

        return $this;
    }

    public function getFollowing(): ?User
    {
        return $this->following;
    }

    public function setFollowing(?User $following): self
    {
        $this->following = $following;

        return $this;
    }

    public function isFollowingByUser(User $user): bool
    {
        foreach ($this->workoutFavs as $workoutFav) {
            if ($workoutFav->getUser() === $user) return true;
        }
        return false;
    }
}

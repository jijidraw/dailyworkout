<?php

namespace App\Entity;

use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"user:link"}, {"read:comment"}},
 * collectionOperations={"get", "post"},
 * itemOperations={"get"})
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:comment", "read:message", "user:link"})
     * @Groups({"workout:display"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_blocked;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_premium;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlInstagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlFacebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlTwitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlTikTok;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $sex;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_disability;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=Program::class, mappedBy="user")
     */
    private $programs;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:comment", "read:message", "user:link"})
     * @Groups({"workout:display"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $feeling;

    /**
     * @ORM\OneToMany(targetEntity=Workout::class, mappedBy="user")
     */
    private $workouts;

    /**
     * @ORM\ManyToMany(targetEntity=SportsList::class, inversedBy="users")
     */
    private $sportlist;

    /**
     * @ORM\OneToMany(targetEntity=Week::class, mappedBy="user")
     */
    private $weeks;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=PostLike::class, mappedBy="user")
     */
    private $likes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imgName;

    /**
     * @ORM\OneToMany(targetEntity=WorkoutFav::class, mappedBy="user")
     */
    private $workoutFavs;

    /**
     * @ORM\OneToMany(targetEntity=Follow::class, mappedBy="follower")
     */
    private $follower;

    /**
     * @ORM\OneToMany(targetEntity=Follow::class, mappedBy="following")
     */
    private $following;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="user")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity=TeamPost::class, mappedBy="user")
     */
    private $teamPosts;

    /**
     * @ORM\ManyToMany(targetEntity=Goal::class, inversedBy="users")
     */
    private $goal;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=TeamMember::class, mappedBy="user")
     */
    private $teamMembers;

    /**
     * @ORM\OneToOne(targetEntity=ImagesProfiles::class, mappedBy="user", cascade={"persist", "remove"})
     * @Groups({"read:comment", "read:message", "user:link"})
     * @Groups({"workout:display"})
     * 
     */
    private $imagesProfiles;

    /**
     * @ORM\OneToMany(targetEntity=PostEvent::class, mappedBy="user")
     */
    private $postEvents;

    /**
     * @ORM\OneToMany(targetEntity=EventParticipate::class, mappedBy="user")
     */
    private $eventParticipates;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="author")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=Challenge::class, mappedBy="creatorChallenge")
     */
    private $challenges;

    /**
     * @ORM\OneToMany(targetEntity=ChallengePlayer::class, mappedBy="user")
     */
    private $challengePlayers;

    /**
     * @ORM\OneToMany(targetEntity=UserNotice::class, mappedBy="user")
     */
    private $userNotices;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="userA")
     */
    private $userA;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="userB")
     */
    private $userB;

    /**
     * @ORM\OneToMany(targetEntity=ChallengeComment::class, mappedBy="user")
     */
    private $challengeComments;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $is_private;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $is_unactive;

    /**
     * @ORM\OneToMany(targetEntity=WorkoutNotation::class, mappedBy="user")
     */
    private $workoutNotations;

    /**
     * @ORM\ManyToMany(targetEntity=Reward::class, mappedBy="user")
     */
    private $rewards;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="user")
     */
    private $notifications;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_welcome;

    /**
     * @ORM\OneToOne(targetEntity=UserMedals::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userMedals;

    /**
     * @ORM\OneToMany(targetEntity=DiaryNote::class, mappedBy="user", orphanRemoval=true)
     */
    private $diaryNotes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_diary;

    /**
     * @ORM\OneToOne(targetEntity=UserPreference::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userPreference;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->posts = new ArrayCollection();
        $this->programs = new ArrayCollection();
        $this->workouts = new ArrayCollection();
        $this->sportlist = new ArrayCollection();
        $this->weeks = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->workoutFavs = new ArrayCollection();
        $this->follower = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->teamPosts = new ArrayCollection();
        $this->goal = new ArrayCollection();
        $this->teamMembers = new ArrayCollection();
        $this->postEvents = new ArrayCollection();
        $this->eventParticipates = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->challenges = new ArrayCollection();
        $this->challengePlayers = new ArrayCollection();
        $this->userNotices = new ArrayCollection();
        $this->userA = new ArrayCollection();
        $this->userB = new ArrayCollection();
        $this->challengeComments = new ArrayCollection();
        $this->workoutNotations = new ArrayCollection();
        $this->rewards = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->diaryNotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isIsBlocked(): ?bool
    {
        return $this->is_blocked;
    }

    public function setIsBlocked(bool $is_blocked): self
    {
        $this->is_blocked = $is_blocked;

        return $this;
    }

    public function isIsPremium(): ?bool
    {
        return $this->is_premium;
    }

    public function setIsPremium(bool $is_premium): self
    {
        $this->is_premium = $is_premium;

        return $this;
    }

    public function getUrlInstagram(): ?string
    {
        return $this->urlInstagram;
    }

    public function setUrlInstagram(?string $urlInstagram): self
    {
        $this->urlInstagram = $urlInstagram;

        return $this;
    }

    public function getUrlFacebook(): ?string
    {
        return $this->urlFacebook;
    }

    public function setUrlFacebook(?string $urlFacebook): self
    {
        $this->urlFacebook = $urlFacebook;

        return $this;
    }

    public function getUrlTwitter(): ?string
    {
        return $this->urlTwitter;
    }

    public function setUrlTwitter(?string $urlTwitter): self
    {
        $this->urlTwitter = $urlTwitter;

        return $this;
    }

    public function getUrlTikTok(): ?string
    {
        return $this->urlTikTok;
    }

    public function setUrlTikTok(?string $urlTikTok): self
    {
        $this->urlTikTok = $urlTikTok;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function isIsDisability(): ?bool
    {
        return $this->is_disability;
    }

    public function setIsDisability(bool $is_disability): self
    {
        $this->is_disability = $is_disability;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Program>
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->setUser($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getUser() === $this) {
                $program->setUser(null);
            }
        }

        return $this;
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
        return $this->CreatedAt;
    }

    public function setCreatedAt(?\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getFeeling(): ?string
    {
        return $this->feeling;
    }

    public function setFeeling(?string $feeling): self
    {
        $this->feeling = $feeling;

        return $this;
    }

    /**
     * @return Collection<int, Workout>
     */
    public function getWorkouts(): Collection
    {
        return $this->workouts;
    }

    public function addWorkout(Workout $workout): self
    {
        if (!$this->workouts->contains($workout)) {
            $this->workouts[] = $workout;
            $workout->setUser($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): self
    {
        if ($this->workouts->removeElement($workout)) {
            // set the owning side to null (unless already changed)
            if ($workout->getUser() === $this) {
                $workout->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SportsList>
     */
    public function getSportlist(): Collection
    {
        return $this->sportlist;
    }

    public function addSportlist(SportsList $sportlist): self
    {
        if (!$this->sportlist->contains($sportlist)) {
            $this->sportlist[] = $sportlist;
        }

        return $this;
    }

    public function removeSportlist(SportsList $sportlist): self
    {
        $this->sportlist->removeElement($sportlist);

        return $this;
    }

    /**
     * @return Collection<int, Week>
     */
    public function getWeeks(): Collection
    {
        return $this->weeks;
    }

    public function addWeek(Week $week): self
    {
        if (!$this->weeks->contains($week)) {
            $this->weeks[] = $week;
            $week->setUser($this);
        }

        return $this;
    }

    public function removeWeek(Week $week): self
    {
        if ($this->weeks->removeElement($week)) {
            // set the owning side to null (unless already changed)
            if ($week->getUser() === $this) {
                $week->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostLike>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(PostLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(PostLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }

    public function getImgName(): ?string
    {
        return $this->imgName;
    }

    public function setImgName(?string $imgName): self
    {
        $this->imgName = $imgName;

        return $this;
    }

    /**
     * @return Collection<int, WorkoutFav>
     */
    public function getWorkoutFavs(): Collection
    {
        return $this->workoutFavs;
    }

    public function addWorkoutFav(WorkoutFav $workoutFav): self
    {
        if (!$this->workoutFavs->contains($workoutFav)) {
            $this->workoutFavs[] = $workoutFav;
            $workoutFav->setUser($this);
        }

        return $this;
    }

    public function removeWorkoutFav(WorkoutFav $workoutFav): self
    {
        if ($this->workoutFavs->removeElement($workoutFav)) {
            // set the owning side to null (unless already changed)
            if ($workoutFav->getUser() === $this) {
                $workoutFav->setUser(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, Follow>
     */
    public function getFollower(): Collection
    {
        return $this->follower;
    }

    public function addFollower(Follow $follower): self
    {
        if (!$this->follower->contains($follower)) {
            $this->follower[] = $follower;
            $follower->setFollower($this);
        }

        return $this;
    }

    public function removeFollower(Follow $follower): self
    {
        if ($this->follower->removeElement($follower)) {
            // set the owning side to null (unless already changed)
            if ($follower->getFollower() === $this) {
                $follower->setFollower(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Follow>
     */
    public function getFollowing(): Collection
    {
        return $this->following;
    }

    public function addFollowing(Follow $following): self
    {
        if (!$this->following->contains($following)) {
            $this->following[] = $following;
            $following->setFollowing($this);
        }

        return $this;
    }

    public function removeFollowing(Follow $following): self
    {
        if ($this->following->removeElement($following)) {
            // set the owning side to null (unless already changed)
            if ($following->getFollowing() === $this) {
                $following->setFollowing(null);
            }
        }

        return $this;
    }

    // fonction crée
    public function isFollowUser(user $user): bool
    {
        foreach ($this->followers as $follower) {
            if ($follower->getUser() === $user) return true;
        }
        return false;
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
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

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
            $teamPost->setUser($this);
        }

        return $this;
    }

    public function removeTeamPost(TeamPost $teamPost): self
    {
        if ($this->teamPosts->removeElement($teamPost)) {
            // set the owning side to null (unless already changed)
            if ($teamPost->getUser() === $this) {
                $teamPost->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Goal>
     */
    public function getGoal(): Collection
    {
        return $this->goal;
    }

    public function addGoal(Goal $goal): self
    {
        if (!$this->goal->contains($goal)) {
            $this->goal[] = $goal;
        }

        return $this;
    }

    public function removeGoal(Goal $goal): self
    {
        $this->goal->removeElement($goal);

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
            $teamMember->setUser($this);
        }

        return $this;
    }

    public function removeTeamMember(TeamMember $teamMember): self
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            // set the owning side to null (unless already changed)
            if ($teamMember->getUser() === $this) {
                $teamMember->setUser(null);
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
            $this->imagesProfiles->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($imagesProfiles !== null && $imagesProfiles->getUser() !== $this) {
            $imagesProfiles->setUser($this);
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
            $postEvent->setUser($this);
        }

        return $this;
    }

    public function removePostEvent(PostEvent $postEvent): self
    {
        if ($this->postEvents->removeElement($postEvent)) {
            // set the owning side to null (unless already changed)
            if ($postEvent->getUser() === $this) {
                $postEvent->setUser(null);
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
            $eventParticipate->setUser($this);
        }

        return $this;
    }

    public function removeEventParticipate(EventParticipate $eventParticipate): self
    {
        if ($this->eventParticipates->removeElement($eventParticipate)) {
            // set the owning side to null (unless already changed)
            if ($eventParticipate->getUser() === $this) {
                $eventParticipate->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Challenge>
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function addChallenge(Challenge $challenge): self
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges[] = $challenge;
            $challenge->setCreatorChallenge($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenges->removeElement($challenge)) {
            // set the owning side to null (unless already changed)
            if ($challenge->getCreatorChallenge() === $this) {
                $challenge->setCreatorChallenge(null);
            }
        }

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
            $challengePlayer->setUser($this);
        }

        return $this;
    }

    public function removeChallengePlayer(ChallengePlayer $challengePlayer): self
    {
        if ($this->challengePlayers->removeElement($challengePlayer)) {
            // set the owning side to null (unless already changed)
            if ($challengePlayer->getUser() === $this) {
                $challengePlayer->setUser(null);
            }
        }

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
            $userNotice->setUser($this);
        }

        return $this;
    }

    public function removeUserNotice(UserNotice $userNotice): self
    {
        if ($this->userNotices->removeElement($userNotice)) {
            // set the owning side to null (unless already changed)
            if ($userNotice->getUser() === $this) {
                $userNotice->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getUserA(): Collection
    {
        return $this->userA;
    }

    public function addUserA(Conversation $userA): self
    {
        if (!$this->userA->contains($userA)) {
            $this->userA[] = $userA;
            $userA->setUserA($this);
        }

        return $this;
    }

    public function removeUserA(Conversation $userA): self
    {
        if ($this->userA->removeElement($userA)) {
            // set the owning side to null (unless already changed)
            if ($userA->getUserA() === $this) {
                $userA->setUserA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getUserB(): Collection
    {
        return $this->userB;
    }

    public function addUserB(Conversation $userB): self
    {
        if (!$this->userB->contains($userB)) {
            $this->userB[] = $userB;
            $userB->setUserB($this);
        }

        return $this;
    }

    public function removeUserB(Conversation $userB): self
    {
        if ($this->userB->removeElement($userB)) {
            // set the owning side to null (unless already changed)
            if ($userB->getUserB() === $this) {
                $userB->setUserB(null);
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
            $challengeComment->setUser($this);
        }

        return $this;
    }

    public function removeChallengeComment(ChallengeComment $challengeComment): self
    {
        if ($this->challengeComments->removeElement($challengeComment)) {
            // set the owning side to null (unless already changed)
            if ($challengeComment->getUser() === $this) {
                $challengeComment->setUser(null);
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

    public function isIsUnactive(): ?bool
    {
        return $this->is_unactive;
    }

    public function setIsUnactive(bool $is_unactive): self
    {
        $this->is_unactive = $is_unactive;

        return $this;
    }

    /**
     * @return Collection<int, WorkoutNotation>
     */
    public function getWorkoutNotations(): Collection
    {
        return $this->workoutNotations;
    }

    public function addWorkoutNotation(WorkoutNotation $workoutNotation): self
    {
        if (!$this->workoutNotations->contains($workoutNotation)) {
            $this->workoutNotations[] = $workoutNotation;
            $workoutNotation->setUser($this);
        }

        return $this;
    }

    public function removeWorkoutNotation(WorkoutNotation $workoutNotation): self
    {
        if ($this->workoutNotations->removeElement($workoutNotation)) {
            // set the owning side to null (unless already changed)
            if ($workoutNotation->getUser() === $this) {
                $workoutNotation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reward>
     */
    public function getRewards(): Collection
    {
        return $this->rewards;
    }

    public function addReward(Reward $reward): self
    {
        if (!$this->rewards->contains($reward)) {
            $this->rewards[] = $reward;
            $reward->addUser($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): self
    {
        if ($this->rewards->removeElement($reward)) {
            $reward->removeUser($this);
        }

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
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    public function isIsWelcome(): ?bool
    {
        return $this->is_welcome;
    }

    public function setIsWelcome(bool $is_welcome): self
    {
        $this->is_welcome = $is_welcome;

        return $this;
    }

    public function getUserMedals(): ?UserMedals
    {
        return $this->userMedals;
    }

    public function setUserMedals(?UserMedals $userMedals): self
    {
        // unset the owning side of the relation if necessary
        if ($userMedals === null && $this->userMedals !== null) {
            $this->userMedals->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($userMedals !== null && $userMedals->getUser() !== $this) {
            $userMedals->setUser($this);
        }

        $this->userMedals = $userMedals;

        return $this;
    }

    /**
     * @return Collection<int, DiaryNote>
     */
    public function getDiaryNotes(): Collection
    {
        return $this->diaryNotes;
    }

    public function addDiaryNote(DiaryNote $diaryNote): self
    {
        if (!$this->diaryNotes->contains($diaryNote)) {
            $this->diaryNotes[] = $diaryNote;
            $diaryNote->setUser($this);
        }

        return $this;
    }

    public function removeDiaryNote(DiaryNote $diaryNote): self
    {
        if ($this->diaryNotes->removeElement($diaryNote)) {
            // set the owning side to null (unless already changed)
            if ($diaryNote->getUser() === $this) {
                $diaryNote->setUser(null);
            }
        }

        return $this;
    }

    public function isIsDiary(): ?bool
    {
        return $this->is_diary;
    }

    public function setIsDiary(?bool $is_diary): self
    {
        $this->is_diary = $is_diary;

        return $this;
    }

    public function getUserPreference(): ?UserPreference
    {
        return $this->userPreference;
    }

    public function setUserPreference(?UserPreference $userPreference): self
    {
        // unset the owning side of the relation if necessary
        if ($userPreference === null && $this->userPreference !== null) {
            $this->userPreference->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($userPreference !== null && $userPreference->getUser() !== $this) {
            $userPreference->setUser($this);
        }

        $this->userPreference = $userPreference;

        return $this;
    }
}

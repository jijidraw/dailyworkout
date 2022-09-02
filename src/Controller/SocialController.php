<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Follow;
use App\Entity\Followers;
use App\Entity\Following;
use App\Entity\Notification;
use App\Entity\Post;
use App\Entity\PostLike;
use App\Entity\User;
use App\Entity\Workout;
use App\Entity\WorkoutFav;
use App\Repository\CommentRepository;
use App\Repository\FollowersRepository;
use App\Repository\FollowingRepository;
use App\Repository\FollowRepository;
use App\Repository\PostLikeRepository;
use App\Repository\PostRepository;
use App\Repository\RewardRepository;
use App\Repository\UserRepository;
use App\Repository\UserStatRepository;
use App\Repository\WorkoutFavRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SocialController extends AbstractController
{
    /**
     * @Route("/post/comment/{id}", name="newcomment", methods={"POST", "GET"})
     */
    public function postComment(UserRepository $userRepository, UserStatRepository $userStatRepository, EntityManagerInterface $em, Post $post, CommentRepository $commentRepository, SerializerInterface $serializer)
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, false);
        $user = $this->getUser();
        $post->setUpdatedAt(new \DateTime());
        $comment = new Comment;
        $comment->setUser($user)->setCreatedAt(new \DateTime())->setPost($post)->setContent($data);
        $em->persist($comment);
        $em->flush();
        // counterstat
        $userStat = $userStatRepository->findOneBy(['user' => $user]);
        $count = $userStat->getComment();
        $userStat->setComment(++$count);
        $userStatRepository->add($userStat, true);

        // notification


        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $name = $currentName->getName();
        $userComment = $currentName->getId();
        $postUser = $post->getUser()->getId();
        $postUserId = $post->getUser();
        if ($postUser != $userComment) {
            $img = $currentName->getImagesProfiles()->getName();
            $notification = new Notification;
            $notification->setUser($postUserId)->setPost($post)->setContent(" $name à répondu à votre publication")->setIsRead(false)->setImage($img);
        }
        $em->persist($notification);
        $em->flush();

        // notification

        $commentId = $comment->getId();
        $json = $serializer->serialize($commentRepository->findOneBy(['id' => $commentId]), 'json', ['groups' => 'read:comment']);
        $response = new Response(
            $json,
            200,
            ["Content-Type" => "application/json"]
        );
        return $response;
    }
    /**
     * @Route("/post/comment/get/{id}", name="getComment", methods={"GET"})
     */
    public function getCommentPost(CommentRepository $commentRepository, Post $post, SerializerInterface $serializerInterface)
    {
        $json = $serializerInterface->serialize($commentRepository->findBy(['post' => $post], ['created_at' => 'DESC']), 'json', ['groups' => 'read:comment']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);

        return $response;
    }
    /**
     * @Route("/post/user/get/{id}", name="getUser", methods={"GET"})
     */
    public function getUserPost(User $user)
    {
        return $this->json([
            $user
        ], 200);
    }
    /**
     * @Route("/post/comment/get", name="getCommentAll", methods={"GET"})
     */
    public function getCommentPostAll(CommentRepository $commentRepository, UserRepository $userRepo)
    {
        return $this->json([
            'comments' => $commentRepository->findBy(['post' => '4'], ['created_at' => 'DESC'])
        ], 200);
    }
    /**
     * @Route("/post/like/{id}", name="newlike", methods={"POST", "GET"})
     */
    public function postLike(EntityManagerInterface $em, Post $post, PostLikeRepository $likerepo)
    {
        $user = $this->getUser();
        if ($post->isLikedByUser($user)) {
            $like = $likerepo->findOneBy([
                'post' => $post,
                'user' => $user
            ]);
            $em->remove($like);
            $em->flush();
            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likerepo->count(['post' => $post])
            ], 200);
        }
        $like = new PostLike();
        $like->setPost($post)
            ->setUser($user);
        $em->persist($like);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $likerepo->count(['post' => $post])
        ], 200);
    }
    /**
     * @Route("/workout/fav/{id}", name="app_workout_fav", methods={"POST", "GET"})
     */
    public function workoutFav(EntityManagerInterface $em, Workout $workout, WorkoutFavRepository $workoutfavrepo, RewardRepository $rewardRepository, UserRepository $userRepository)
    {
        $user = $this->getUser();
        if ($workout->isFavsByUser($user)) {
            $workoutFav = $workoutfavrepo->findOneBy([
                'workout' => $workout,
                'user' => $user
            ]);
            $em->remove($workoutFav);
            $em->flush();
            return $this->json([
                'code' => 200,
                'message' => 'Workout retiré des favoris',
                'likes' => $workoutfavrepo->count(['workout' => $workout])
            ], 200);
        }
        $workoutFav = new WorkoutFav;
        $workoutFav->setWorkout($workout)
            ->setUser($user);
        $em->persist($workoutFav);
        $em->flush();

        $count = $workoutfavrepo->count(['workout' => $workout]);
        if ($count == 1) {
            $userIdentifier = $user->getUserIdentifier();
            $currentUser = $userRepository->findOneBy(['email' => $userIdentifier]);
            $reward = $rewardRepository->findOneBy(['id' => 2]);
            $currentUser->addReward($reward);
            $userRepository->add($currentUser, true);
        }

        return $this->json([
            'code' => 200,
            'message' => 'Workout ajouté aux favoris',
            'likes' => $workoutfavrepo->count(['workout' => $workout])
        ], 200);
    }
    /**
     * @Route("/user/followers/add/{id}", name="userFollowers", methods={"POST", "GET"})
     */
    public function userFollower(EntityManagerInterface $em, User $following, FollowRepository $followerRepo, UserStatRepository $userStatRepository)
    {
        $user = $this->getUser();
        if ($userFollower = $followerRepo->findOneBy(
            [
                'follower' => $user,
                'following' => $following
            ]
        )) {
            $userFollower = $followerRepo->findOneBy([
                'follower' => $user,
                'following' => $following
            ]);
            $em->remove($userFollower);
            $em->flush();
            return $this->json([
                'code' => 200,
                'message' => 'Vous ne le suivez plus',
                'followers' => $followerRepo->count(['follower' => $following])
            ], 200);
        }


        $userFollower = new Follow;
        $userFollower->setFollower($user)
            ->setFollowing($following);
        $em->persist($userFollower);
        $em->flush();

        $userStat = $userStatRepository->findOneBy(['user' => $user]);
        $userfollowCount = $followerRepo->count(['following' => $user]);
        $userfollowerCount = $followerRepo->count(['follower' => $user]);
        $userStat->setFollower($userfollowCount)->setFollowing($userfollowerCount);
        $followStat = $userStatRepository->findOneBy(['user' => $following]);
        $followFollowCount = $followerRepo->count(['following' => $following]);
        $followFollowerCount = $followerRepo->count(['follower' => $following]);
        $followStat->setFollower($followFollowCount)->setFollowing($followFollowerCount);
        $userStatRepository->add($followStat, true, $userStat, true);
        return $this->json([
            'code' => 200,
            'message' => 'Vous le suivez',
            'followers' => $followerRepo->count(['follower' => $following])
        ], 200);
    }
}

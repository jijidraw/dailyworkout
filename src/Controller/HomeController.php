<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Images;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\ChallengePlayerRepository;
use App\Repository\ChallengeRepository;
use App\Repository\FollowRepository;
use App\Repository\NotificationRepository;
use App\Repository\PostRepository;
use App\Repository\RewardRepository;
use App\Repository\TeamMemberRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Repository\UserStatRepository;
use App\Repository\WeekRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, UserStatRepository $userStatRepository, RewardRepository $rewardRepository, EntityManagerInterface $em, PostRepository $postrepo, ChallengePlayerRepository $challengePlayerRepository, WeekRepository $weekRepository, ChallengeRepository $challengeRepository, FollowRepository $followRepository, NotificationRepository $notificationRepository, TeamMemberRepository $teamMemberRepository, TeamRepository $teamRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $userIdentifier = $user->getUserIdentifier();
        $currentUser = $userRepository->findOneBy(['email' => $userIdentifier]);

        // check si c'est la première venue de l'utilisateur

        if ($currentUser->isIsWelcome(true)) {
            return $this->redirectToRoute('app_user_edit', ['id' => $currentUser->getId()]);
        }
        $userStat = $userStatRepository->findOneBy(['user' => $user]);
        $follows = $followRepository->findBy(['follower' => $user]);
        $challenges = $challengeRepository->findBy(['is_public' => true], ['created_at' => 'DESC'], 20);
        foreach ($follows as $follow) {
            $array[] = $follow->getFollowing();
            array_push($array, $user);
        }
        if (!empty($array)) {
            $post1 = $postrepo->findBy(array('user' => $array), ['updated_at' => 'DESC']);
            $post2 = $postrepo->findBy([], ['updated_at' => 'DESC'], 20);
            $posts = array_merge($post1, $post2, $challenges);
            $posts = array_map("unserialize", array_unique(array_map("serialize", $posts)));
            shuffle($posts);
        } else {
            $posts = $postrepo->findBy([], ['updated_at' => 'DESC'], 20);
        }

        // programme du jour

        $today = date('l');
        $workoutOfTheDay = $weekRepository->findBy(['user' => $user, 'dayweek' => $today]);

        // recherche de mes teams

        $teamMembers = $teamMemberRepository->findBy(['user' => $user, 'is_waiting' => false, 'is_blocked' => false, 'is_invite' => false]);
        if (!empty($teamMembers)) {
            foreach ($teamMembers as $teamMember) {
                $arrayTeam[] = $teamMember->getTeam()->getId();
            }
            $teams = $teamRepository->findBy(array('id' => $arrayTeam), ['updated_at' => 'DESC'], 4);
        } else {
            $teams = null;
        }

        // post
        $post = new Post();
        $postForm = $this->createForm(PostType::class, $post);
        $postForm->handleRequest($request);


        // post form
        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $countPost = $userStat->getPost();
            $userStat->setPost(++$countPost);
            $userStatRepository->add($userStat, true);
            $post->setUser($user);
            $post->setCreatedAt(new DateTime());
            $post->setUpdatedAt(new DateTime());
            $postrepo->add($post, true);
            $empty = $postForm->get('images')->getData();

            if (!empty($empty)) {

                $images = $postForm->get('images')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('post_directory'),
                    $fichier
                );

                $img = new Images();
                $img->setName($fichier);
                $post->addImage($img);
            };
            $em->persist($post);
            $em->flush();
            // commentaire
            // ajout des trophées
            if ($countPost == 1) {

                $reward = $rewardRepository->findOneBy(['id' => 10]);
                $currentUser->addReward($reward);
                $userRepository->add($currentUser, true);
            }
            // ajout des trophées

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('home/index.html.twig', [
            'postform' => $postForm->createView(),
            'notifications' => $notificationRepository->findBy(['user' => $user], ['created_at' => 'DESC']),
            'post' => $posts,
            'today' => $workoutOfTheDay,
            'userChallenge' => $challengePlayerRepository->findBy(['user' => $user, 'is_challenged' => true]),
            'teams' => $teams
        ]);
    }
    /**
     * @Route("/welcome", name="app_welcome")
     */
    public function welcome(Request $request, UserStatRepository $userStatRepository, EntityManagerInterface $em, PostRepository $postrepo, ChallengePlayerRepository $challengePlayerRepository, WeekRepository $weekRepository, ChallengeRepository $challengeRepository, FollowRepository $followRepository, NotificationRepository $notificationRepository): Response
    {

        $user = $this->getUser();
        $userStat = $userStatRepository->findOneBy(['user' => $user]);
        $follows = $followRepository->findBy(['follower' => $user]);
        $challenges = $challengeRepository->findBy(['is_public' => true], ['created_at' => 'DESC'], 20);
        foreach ($follows as $follow) {
            $array[] = $follow->getFollowing();
            array_push($array, $user);
        }
        if (!empty($array)) {
            $post1 = $postrepo->findBy(array('user' => $array), ['updated_at' => 'DESC']);
            $post2 = $postrepo->findBy([], ['updated_at' => 'DESC'], 20);
            $posts = array_merge($post1, $post2, $challenges);
            $posts = array_map("unserialize", array_unique(array_map("serialize", $posts)));
            shuffle($posts);
        } else {
            $posts = $postrepo->findBy([], ['updated_at' => 'DESC'], 20);
        }

        // programme du jour

        $today = date('l');
        $workoutOfTheDay = $weekRepository->findBy(['user' => $user, 'dayweek' => $today]);

        // post
        $post = new Post();
        $postForm = $this->createForm(PostType::class, $post);
        $postForm->handleRequest($request);


        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $countPost = $userStat->getPost();
            $userStat->setPost(++$countPost);
            $userStatRepository->add($userStat, true);
            $post->setUser($user);
            $post->setCreatedAt(new DateTime());
            $post->setUpdatedAt(new DateTime());
            $postrepo->add($post, true);
            $empty = $postForm->get('images')->getData();

            if (!empty($empty)) {

                $images = $postForm->get('images')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('post_directory'),
                    $fichier
                );

                $img = new Images();
                $img->setName($fichier);
                $post->addImage($img);
            };
            $em->persist($post);
            $em->flush();
            // commentaire

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('home/index.html.twig', [
            'postform' => $postForm->createView(),
            'notifications' => $notificationRepository->findBy(['user' => $user], ['created_at' => 'DESC']),
            'post' => $posts,
            'today' => $workoutOfTheDay,
            'userChallenge' => $challengePlayerRepository->findBy(['user' => $user, 'is_challenged' => true]),
        ]);
    }
}

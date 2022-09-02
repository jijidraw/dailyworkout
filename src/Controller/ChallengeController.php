<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\ChallengeComment;
use App\Entity\ChallengePlayer;
use App\Entity\Images;
use App\Entity\Notification;
use App\Entity\User;
use App\Entity\Workout;
use App\Form\Challenge1Type;
use App\Form\ChallengeType;
use App\Form\CommentChallengeType;
use App\Repository\ChallengeCommentRepository;
use App\Repository\ChallengePlayerRepository;
use App\Repository\ChallengeRepository;
use App\Repository\FollowRepository;
use App\Repository\RewardRepository;
use App\Repository\UserRepository;
use App\Repository\UserStatRepository;
use App\Repository\WorkoutRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/challenge")
 */
class ChallengeController extends AbstractController
{
    /**
     * @Route("/", name="app_challenge_index", methods={"GET"})
     */
    public function index(ChallengeRepository $challengeRepository, ChallengePlayerRepository $challengePlayerRepository): Response
    {
        $user = $this->getUser();
        $lastChallenge = $challengeRepository->findBy([], ['created_at' => 'DESC'], 20);
        $invited = $challengePlayerRepository->findBy(['user' => $user, 'is_invite' => true]);
        $inProgress = $challengePlayerRepository->findBy(['user' => $user, 'is_challenged' => true]);
        $done = $challengePlayerRepository->findBy(['user' => $user, 'is_accomplish' => true]);
        return $this->render('challenge/index.html.twig', [
            'challenges' => $challengeRepository->findBy(['creatorChallenge' => $user], ['created_at' => 'DESC']),
            'invited' => $invited,
            'inProgress' => $inProgress,
            'done' => $done,
            'lastChallenge' => $lastChallenge
        ]);
    }

    /**
     * @Route("/new", name="app_challenge_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ChallengeRepository $challengeRepository): Response
    {
        $user = $this->getUser();
        $challenge = new Challenge();
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $challenge->setCreatorChallenge($user)->setIsPublic(false);
            $challengeRepository->add($challenge, true);

            return $this->redirectToRoute('app_challenge_step2', ['id' => $challenge->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('challenge/new.html.twig', [
            'challenge' => $challenge,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/new/step2/{id}", name="app_challenge_step2", methods={"GET", "POST"})
     */
    public function newStep2(Request $request, UserStatRepository $userStatRepository, Challenge $challenge, FollowRepository $followRepository, WorkoutRepository $workoutRepository, ChallengeRepository $challengeRepository, UserRepository $userRepository, RewardRepository $rewardRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(Challenge1Type::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $challenge->setIsPublic(true);
            $empty = $form->get('images')->getData();
            if (!empty($empty)) {
                $images = $form->get('images')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('post_directory'),
                    $fichier
                );
                $img = new Images();
                $img->setName($fichier);
                $challenge->setImages($img);
            }

            $userStat = $userStatRepository->findOneBy(['user' => $user]);
            $count = $userStat->getChallenge();
            $userStat->setChallenge(++$count);
            $userStatRepository->add($userStat, true);
            if ($count == 1) {
                $userIdentifier = $user->getUserIdentifier();
                $currentUser = $userRepository->findOneBy(['email' => $userIdentifier]);
                $reward = $rewardRepository->findOneBy(['id' => 4]);
                $currentUser->addReward($reward);
                $userRepository->add($currentUser, true);
            }

            $challengeRepository->add($challenge, true);
            return $this->redirectToRoute('app_challenge_show', ['id' => $challenge->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('challenge/new_step_2.html.twig', [
            'challenge' => $challenge,
            'follows' => $followRepository->findBy(['following' => $user]),
            'workouts' => $workoutRepository->findBy(['user' => $user], ['created_at' => 'DESC']),
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_challenge_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Challenge $challenge, FollowRepository $followRepository, ChallengePlayerRepository $challengePlayerRepository, EntityManagerInterface $em, ChallengeCommentRepository $challengeCommentRepository): Response
    {
        $user = $this->getUser();

        $challenger = $challengePlayerRepository->findOneBy(['user' => $user, 'challenge' => $challenge]);
        $challengers = $challengePlayerRepository->findChallengers(['challenge' => $challenge]);
        $accomplish = $challengePlayerRepository->findAccomplish(['challenge' => $challenge]);
        $invited = $challengePlayerRepository->findInvited(['challenge' => $challenge]);
        $comments = $challengeCommentRepository->findBy(['challenge' => $challenge]);
        // commentaire challenge
        $comment = new ChallengeComment();
        $form = $this->createForm(CommentChallengeType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($user)->setChallenge($challenge)->setCreatedAt(new DateTime());
            $challengeCommentRepository->add($comment, true);
            // $empty = $form->get('image')->getData();

            // if (!empty($empty)) {

            //     $images = $form->get('image')->getData();
            //     $fichier = md5(uniqid()) . '.' . $images->guessExtension();
            //     $images->move(
            //         $this->getParameter('post_directory'),
            //         $fichier
            //     );

            //     $img = new Images();
            //     $img->setName($fichier);
            //     $comment->setImage($img);
            // };
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('app_challenge_show', ['id' => $challenge->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('challenge/show.html.twig', [
            'challenge' => $challenge,
            'follows' => $followRepository->findBy(['following' => $user]),
            'challengers' => $challengers,
            'accomplish' => $accomplish,
            'invited' => $invited,
            'challenger' => $challenger,
            'form' => $form->createView(),
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/{id}/{user}", name="app_challenge_invite", methods={"GET"})
     */
    public function addChallenger(Challenge $challenge, ChallengePlayerRepository $challengePlayerRepository, User $user, EntityManagerInterface $em, UserRepository $userRepository)
    {
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $name = $currentName->getName();
        $img = $currentName->getImagesProfiles()->getName();
        $isChallenger = $challengePlayerRepository->findOneBy(['user' => $user, 'challenge' => $challenge]);
        if (!empty($isChallenger)) {
            return $this->json([
                'code' => 200,
                'message' => 'Cet utilisateur à déjà reçu une invitation'
            ], 200);
        } else {
            $challenger = new ChallengePlayer;
            $challenger->setUser($user)->setChallenge($challenge)->setCreatedAt(new DateTime())->setIsAccomplish(false)->setIsInvite(true)->setIsChallenged(false);
            $em->persist($challenger);
            $em->flush();
            $notification = new Notification;
            $notification->setUser($user)->setChallenge($challenge)->setContent(" $name vous à lancé un défi")->setIsRead(false)->setImage($img);
            $em->persist($notification);
            $em->flush();
            return $this->json([
                'code' => 200,
                'message' => 'Invitation envoyée'
            ], 200);
        }
    }
    /**
     * @Route("/set/{id}/{workout}", name="app_challenge_workout", methods={"GET"})
     */
    public function addWorkoutChallenge(Challenge $challenge, Workout $workout, EntityManagerInterface $em)
    {
        $challenge->setWorkout($workout);
        $em->persist($challenge);
        $em->flush();
        return $this->redirectToRoute('app_challenge_step2', ['id' => $challenge->getId()], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/accept/{id}/{user}", name="app_challenge_accept", methods={"GET"})
     */
    public function addResponseChallenge(Challenge $challenge, User $user, UserStatRepository $userStatRepository, UserRepository $userRepository, RewardRepository $rewardRepository, EntityManagerInterface $em)
    {
        $challenger = new ChallengePlayer;
        $challenger->setUser($user)->setChallenge($challenge)->setCreatedAt(new DateTime())->setIsAccomplish(false)->setIsInvite(false)->setIsChallenged(true);
        $em->persist($challenger);
        $em->flush();
        $userStat = $userStatRepository->findOneBy(['user' => $user]);
        $count = $userStat->getChallengeAccepted();
        $userStat->setChallengeAccepted(++$count);
        $userStatRepository->add($userStat, true);
        if ($count == 1) {
            $userIdentifier = $user->getUserIdentifier();
            $currentUser = $userRepository->findOneBy(['email' => $userIdentifier]);
            $reward = $rewardRepository->findOneBy(['id' => 5]);
            $currentUser->addReward($reward);
            $userRepository->add($currentUser, true);
        }
        return $this->json([
            'code' => 200,
            'message' => 'Challenge accepté'
        ], 200);
    }
    /**
     * @Route("/accept/{id}", name="app_challenge_accept_invited", methods={"GET"})
     */
    public function addResponseChallengeInvited(ChallengePlayer $challengePlayer, ChallengePlayerRepository $challengePlayerRepository)
    {
        $challengePlayer->setIsChallenged(true);
        $challengePlayerRepository->set($challengePlayer, true);
        return $this->json([
            'code' => 200,
            'message' => 'Challenge accepté'
        ], 200);
    }
    /**
     * @Route("/accomplish/{id}/{challenge}", name="app_challenge_accomplish", methods={"GET"})
     */
    public function addIsAccomplish(User $user, Challenge $challenge, ChallengePlayerRepository $challengePlayerRepository, EntityManagerInterface $em, UserStatRepository $userStatRepository, UserRepository $userRepository, RewardRepository $rewardRepository)
    {
        $creatorChallenge = $challenge->getCreatorChallenge;
        $creatorName = $challenge->getCreatorChallenge()->getName();
        $userName = $user->getName();
        $img = $user->getImagesProfiles()->getName();
        $notification = new Notification;
        $notification->setUser($creatorChallenge)->setChallenge($challenge)->setContent(" $creatorName ! $userName à accompli votre défi !")->setIsRead(false)->setImage($img);
        $challenger = $challengePlayerRepository->findOneBy(['user' => $user, 'challenge' => $challenge]);
        $challenger->setIsAccomplish(true)->setIsChallenged(false);
        $em->persist($challenger);
        $em->flush();

        $userStat = $userStatRepository->findOneBy(['user' => $user]);
        $count = $userStat->getChallengeAccomplish();
        $userStat->setChallengeAccomplish(++$count);
        $userStatRepository->add($userStat, true);
        if ($count == 1) {
            $userIdentifier = $user->getUserIdentifier();
            $currentUser = $userRepository->findOneBy(['email' => $userIdentifier]);
            $reward = $rewardRepository->findOneBy(['id' => 6]);
            $currentUser->addReward($reward);
            $userRepository->add($currentUser, true);
        }

        return $this->json([
            'code' => 200,
            'message' => 'Challenge accompli'
        ], 200);
    }

    /**
     * @Route("/{id}", name="app_challenge_delete", methods={"POST"})
     */
    public function delete(Request $request, Challenge $challenge, ChallengeRepository $challengeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $challenge->getId(), $request->request->get('_token'))) {
            $challengeRepository->remove($challenge, true);
        }

        return $this->redirectToRoute('app_challenge_index', [], Response::HTTP_SEE_OTHER);
    }
}

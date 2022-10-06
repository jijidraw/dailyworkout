<?php

namespace App\Controller\User;

use App\Entity\Conversation;
use App\Entity\Diary;
use App\Entity\Goal;
use App\Entity\ImagesProfiles;
use App\Entity\SportsList;
use App\Entity\User;
use App\Form\GoalType;
use App\Form\User1Type;
use App\Form\User2Type;
use App\Form\UserSports;
use App\Form\UserType;
use App\Repository\ConversationRepository;
use App\Repository\FollowRepository;
use App\Repository\GoalRepository;
use App\Repository\ImagesProfilesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\PostRepository;
use App\Repository\SportsListRepository;
use App\Repository\UserRepository;
use App\Repository\WeekRepository;
use App\Repository\WorkoutRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user, WeekRepository $weekRepository, WorkoutRepository $workoutRepository, ConversationRepository $conversationRepository, UserRepository $userRepository, FollowRepository $followRepository): Response
    {
        // rechercher si l'on suit l'utilisateur
        $appUser = $this->getUser();
        $IsFollow = $followRepository->findOneBy(['following' => $user, 'follower' => $appUser]);
        // trouver si la conversation avec l'utilisateur existe
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $schemaA = $conversationRepository->findOneBy(['userA' => $currentName, 'userB' => $user]);
        $schemaB = $conversationRepository->findOneBy(['userB' => $currentName, 'userA' => $user]);
        if (empty($schemaA) && empty($schemaB)) {
            $response = "pas de conversation";
        } else {
            $response = "conversation existe";
        }
        return $this->render('user/user/show.html.twig', [
            'user' => $user,
            'monday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'monday']),
            'tuesday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'tuesday']),
            'wednesday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'wednesday']),
            'thursday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'thursday']),
            'friday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'friday']),
            'saturday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'saturday']),
            'sunday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'sunday']),
            'workouts' => $workoutRepository->findBy(['user' => $user]),
            'reponse' => $response,
            'isFollow' => $IsFollow
        ]);
    }
    /**
     * @Route("/posts/{id}", name="app_user_showPost", methods={"GET"})
     */
    public function showPost(User $user): Response
    {
        return $this->render('user/user/showPost.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * @Route("/cloud/goals/{id}", name="app_user_goal", methods={"GET", "POST"})
     */
    public function findGoal(User $user, GoalRepository $goalRepository, Request $request, UserRepository $userRepository): Response
    {
        $goal = new Goal();
        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $goal->addUser($user)->setCreatedAt(new DateTime());
            $goalRepository->add($goal, true);
            return $this->redirectToRoute('app_user_goal', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }
        $formUser = $this->createForm(User1Type::class, $user);
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
        };
        $goals = $goalRepository->findBy([], ['name' => 'ASC']);
        $userRepository->add($user, true);
        return $this->render('user/user/_clouds_goals.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'formUser' => $formUser->createView(),
            'goals' => $goals
        ]);
    }
    /**
     * @Route("/add/goals/{id}/{goals}", name="app_add_goal", methods={"GET", "POST"})
     */
    public function addGoal(User $user, Goal $goal, Request $request, UserRepository $userRepository): Response
    {
        $route = $request->headers->get('referer');
        $user->addGoal($goal);
        $userRepository->add($user, true);
        $this->addFlash('success', 'Objectif ajouté');
        return $this->redirect($route);
    }
    /**
     * @Route("/follower/{id}", name="app_user_showFollowers", methods={"GET"})
     */
    public function showFollowers(User $user, FollowRepository $followRepository): Response
    {
        // $json = $serializer->serialize($followRepository->findBy(['following' => $user]), 'json', ['groups' => 'user:link']);
        $followers = $followRepository->findBy(['following' => $user]);
        // $response = new Response(
        //     $json,
        //     200,
        //     [
        //         "Content-Type" => "application/json"
        //     ]
        // );
        // return $response;
        return $this->render('user/user/userFollow.html.twig', [
            'user' => $user,
            'followers' => $followers,

        ]);
    }
    /**
     * @Route("/following/{id}", name="app_user_showFollows", methods={"GET"})
     */
    public function showFollows(User $user, FollowRepository $followRepository, SerializerInterface $serializer): Response
    {
        // $json = $serializer->serialize($followRepository->findBy(['follower' => $user]), 'json', ['groups' => 'user:link']);
        // $response = new Response(
        //     $json,
        //     200,
        //     [
        //         "Content-Type" => "application/json"
        //     ]
        // );
        // return $response;
        $followings = $followRepository->findBy(['follower' => $user]);
        return $this->render('user/user/userFollower.html.twig', [
            'user' => $user,
            'followings' => $followings,

        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, EntityManagerInterface $em, ImagesProfilesRepository $imagesProfilesRepository): Response
    {
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $userId = $currentName->getId();
        if ($userId != $user->getId()) {
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $empty = $form->get('image')->getData();
            if (!empty($empty)) {
                // fonction pour effacer l'ancienne image de profil
                $userId = $user->getId();
                $ImgRmv = $imagesProfilesRepository->findOneBy(['user' => $userId]);
                if ($ImgRmv->getName() != 'login.png') {
                    $ImgRmvName = $ImgRmv->getName();
                    unlink($this->getParameter('profil_directory') . '/' . $ImgRmvName);
                    $em->remove($ImgRmv);
                    $em->flush();
                } else {
                    $em->remove($ImgRmv);
                    $em->flush();
                }

                // enregistrement de la nouvelle image

                $images = $form->get('image')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('profil_directory'),
                    $fichier
                );
                $img = new ImagesProfiles();
                $img->setName($fichier);
                $img->setUser($user);
                $user->setImagesProfiles($img);
            };
            $userRepository->add($user, true);
            if ($user->isIsWelcome(true)) {
                $user->setIsWelcome(false);
                $userRepository->add($user, true);

                return $this->redirectToRoute('app_next_step');
            }
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }

        return $this->renderForm('user/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="app_user_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_user_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/conversation/{id}", name="app_conversation_search", methods={"GET"})
     */
    public function createLoadConversation(ConversationRepository $conversationRepository, User $user, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $schemaA = $conversationRepository->findOneBy(['userA' => $currentName, 'userB' => $user]);
        $schemaB = $conversationRepository->findOneBy(['userB' => $currentName, 'userA' => $user]);
        if (empty($schemaA) && empty($schemaB)) {
            $conversation = new Conversation;
            $conversation->setUserA($currentName)->setUserB($user);
            $conversationRepository->add($conversation, true);
            $em->persist($conversation);
            $em->flush();
            return $this->redirectToRoute('app_conversation_show', ['id' => $conversation->getId()], Response::HTTP_SEE_OTHER);
        } else {
            if (empty($schemaA)) {
                return $this->redirectToRoute('app_conversation_show', ['id' => $schemaB->getId()], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_conversation_show', ['id' => $schemaA->getId()], Response::HTTP_SEE_OTHER);
            }
        }
    }
}

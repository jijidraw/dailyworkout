<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\Post;
use App\Entity\UserStat;
use App\Repository\NotificationRepository;
use App\Repository\PostRepository;
use App\Repository\UserMedalsRepository;
use App\Repository\UserRepository;
use App\Repository\UserStatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedalController extends AbstractController
{
    /**
     * @Route("/medal/bronze/{id}", name="app_medal_bronze")
     */
    public function giveBronze(Post $post, PostRepository $postRepository, UserRepository $userRepository, UserStatRepository $userStatRepository, UserMedalsRepository $userMedalsRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $name = $currentName->getName();
        $img = $currentName->getImagesProfiles()->getName();
        $medalPost = $post->getBronze();
        $post->setBronze(++$medalPost);
        $postRepository->add($post, true);

        $medalUser = $userMedalsRepository->findOneBy(['user' => $user]);
        $medalUser->setBronze(false);
        $userMedalsRepository->add($medalUser, true);
        $userPost = $post->getUser();
        $statUserPost = $userStatRepository->findOneBy(['user' => $userPost]);
        $userPoints = $statUserPost->getPoints();
        $Points = 5;
        $statUserPost->setPoints($userPoints + $Points);
        $userStatRepository->add($statUserPost, true);
        $notification = new Notification;
        $notification->setUser($userPost)->setPost($post)->setContent(" $name t'as donné un trophé de bronze")->setIsRead(false)->setImage($img);
        $em->persist($notification);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Médaille donnée',
        ], 200);
    }
    /**
     * @Route("/medal/silver/{id}", name="app_medal_silver")
     */
    public function giveSilver(Post $post, PostRepository $postRepository, UserRepository $userRepository, UserStatRepository $userStatRepository, UserMedalsRepository $userMedalsRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $name = $currentName->getName();
        $img = $currentName->getImagesProfiles()->getName();
        $medalPost = $post->getSilver();
        $post->setSilver(++$medalPost);
        $postRepository->add($post, true);

        $medalUser = $userMedalsRepository->findOneBy(['user' => $user]);
        $medalUser->setSilver(false);
        $userMedalsRepository->add($medalUser, true);
        $userPost = $post->getUser();
        $statUserPost = $userStatRepository->findOneBy(['user' => $userPost]);
        $userPoints = $statUserPost->getPoints();
        $Points = 10;
        $statUserPost->setPoints($userPoints + $Points);
        $userStatRepository->add($statUserPost, true);
        $notification = new Notification;
        $notification->setUser($userPost)->setPost($post)->setContent(" $name t'as donné un trophé d'argent")->setIsRead(false)->setImage($img);
        $em->persist($notification);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Médaille donnée',
        ], 200);
    }
    /**
     * @Route("/medal/gold/{id}", name="app_medal_gold")
     */
    public function giveGold(Post $post, PostRepository $postRepository, UserRepository $userRepository, UserStatRepository $userStatRepository, UserMedalsRepository $userMedalsRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $name = $currentName->getName();
        $img = $currentName->getImagesProfiles()->getName();
        $medalPost = $post->getGold();
        $post->setGold(++$medalPost);
        $postRepository->add($post, true);

        $medalUser = $userMedalsRepository->findOneBy(['user' => $user]);
        $medalUser->setGold(false);
        $userMedalsRepository->add($medalUser, true);
        $userPost = $post->getUser();
        $statUserPost = $userStatRepository->findOneBy(['user' => $userPost]);
        $userPoints = $statUserPost->getPoints();
        $Points = 20;
        $statUserPost->setPoints($userPoints + $Points);
        $userStatRepository->add($statUserPost, true);
        $notification = new Notification;
        $notification->setUser($userPost)->setPost($post)->setContent(" $name t'as donné un trophée d'or")->setIsRead(false)->setImage($img);
        $em->persist($notification);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Médaille donnée',
        ], 200);
    }
    /**
     * @Route("/admin/medals/reset}", name="app_medals_reset")
     */
    public function resetMedals(UserMedalsRepository $userMedalsRepository, EntityManagerInterface $em)
    {
        $medals = $userMedalsRepository->findAll();
        foreach ($medals as $medal) {
            $medal->setSilver(true)->setGold(true)->setBronze(true);
            $userMedalsRepository->add($medal, true);
            $em->persist($medal);
            $em->flush();
        }
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
}

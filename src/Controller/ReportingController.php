<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\ChallengeComment;
use App\Entity\Comment;
use App\Entity\Message;
use App\Entity\Post;
use App\Entity\Reporting;
use App\Entity\Team;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/reporting")
 */
class ReportingController extends AbstractController
{

    /**
     * @Route("/comment/{id}/{user}", name="app_reporting_comment", methods={"GET"})
     */
    public function reportComment(Comment $comment, EntityManagerInterface $em, User $user)
    {
        $userReported = $comment->getUser();
        $reporting = new Reporting();
        $reporting->setUser($user)->setUserReported($userReported)->setComment($comment)->setReportedAt(new DateTime());
        $em->persist($reporting);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Votre signalement à bien été pris en compte'
        ], 200);
    }
    /**
     * @Route("/post/{id}/{user}", name="app_reporting_post", methods={"GET"})
     */
    public function reportPost(Post $comment, EntityManagerInterface $em, User $user)
    {
        $userReported = $comment->getUser();
        $reporting = new Reporting();
        $reporting->setUser($user)->setUserReported($userReported)->setPost($comment)->setReportedAt(new DateTime());
        $em->persist($reporting);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Votre signalement à bien été pris en compte'
        ], 200);
    }
    /**
     * @Route("/team/{id}/{user}", name="app_reporting_team", methods={"GET"})
     */
    public function reportTeam(Team $comment, EntityManagerInterface $em, User $user)
    {
        $reporting = new Reporting();
        $reporting->setUser($user)->setTeam($comment)->setReportedAt(new DateTime());
        $em->persist($reporting);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Votre signalement à bien été pris en compte'
        ], 200);
    }
    /**
     * @Route("/message/{id}/{user}", name="app_reporting_message", methods={"GET"})
     */
    public function reportMessage(Message $comment, EntityManagerInterface $em, User $user)
    {
        $userReported = $comment->getUser();
        $reporting = new Reporting();
        $reporting->setUser($user)->setUserReported($userReported)->setPrivateMessage($comment)->setReportedAt(new DateTime());
        $em->persist($reporting);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Votre signalement à bien été pris en compte'
        ], 200);
    }
    /**
     * @Route("/post/{id}/{user}", name="app_reporting_user", methods={"GET"})
     */
    public function reportUser(User $comment, EntityManagerInterface $em, User $user)
    {
        $reporting = new Reporting();
        $reporting->setUser($user)->setUserReported($comment)->setReportedAt(new DateTime());
        $em->persist($reporting);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Votre signalement à bien été pris en compte'
        ], 200);
    }
    /**
     * @Route("/post/{id}/{user}", name="app_reporting_challenge", methods={"GET"})
     */
    public function reportChallenge(Challenge $comment, EntityManagerInterface $em, User $user)
    {
        $userReported = $comment->getCreatorChallenge();
        $reporting = new Reporting();
        $reporting->setUser($user)->setUserReported($userReported)->setChallenge($comment)->setReportedAt(new DateTime());
        $em->persist($reporting);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Votre signalement à bien été pris en compte'
        ], 200);
    }
    /**
     * @Route("/post/{id}/{user}", name="app_reporting_challenge_comment", methods={"GET"})
     */
    public function reportChallengeComment(ChallengeComment $comment, EntityManagerInterface $em, User $user)
    {
        $userReported = $comment->getUser();
        $reporting = new Reporting();
        $reporting->setUser($user)->setUserReported($userReported)->setChallengeComment($comment)->setReportedAt(new DateTime());
        $em->persist($reporting);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Votre signalement à bien été pris en compte'
        ], 200);
    }
}

<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Entity\MuscleGroup;
use App\Entity\SportsList;
use App\Repository\EventRepository;
use App\Repository\FollowRepository;
use App\Repository\GoalRepository;
use App\Repository\MuscleGroupRepository;
use App\Repository\SportsListRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(SportsListRepository $sportsListRepository, UserRepository $userRepository, GoalRepository $goalRepository): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'sportList' => $sportsListRepository->findBy([], ['name' => 'ASC']),
            'users' => $userRepository->findBy(['is_unactive' => false, 'is_private' => false], ['id' => 'DESC'], 20),
            'goals' => $goalRepository->findBy([], ['created_at' => 'DESC'])
        ]);
    }
    /**
     * @Route("/search/user", name="app_search_user", methods={"POST", "GET"})
     */
    public function searchUser(UserRepository $userRepository, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($userRepository->findBy(['is_unactive' => false, 'is_private' => false]), 'json', ['groups' => 'user:link']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/search/user/sport/{id}", name="app_search_user_sport", methods={"POST", "GET"})
     */
    public function searchUserBySport(UserRepository $userRepository, SerializerInterface $serializer, SportsList $sportList)
    {
        $json = $serializer->serialize($userRepository->searchBySport(['sportlist' => $sportList]), 'json', ['groups' => 'user:link']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/search/user/goal/{id}", name="app_search_user_goal", methods={"POST", "GET"})
     */
    public function searchUserByGoal(UserRepository $userRepository, SerializerInterface $serializer, Goal $goal)
    {
        $json = $serializer->serialize($userRepository->searchByGoal(['goal' => $goal]), 'json', ['groups' => 'user:link']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/search/workout/{id}", name="app_search_workout", methods={"POST", "GET"})
     */
    public function searchWorkout(WorkoutRepository $workoutRepository, MuscleGroup $muscle, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($workoutRepository->searchByMuscle(['muscleGroup' => $muscle]), 'json', ['groups' => 'workout:display']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/search/workout/sport/{id}", name="app_search_workout_sport", methods={"POST", "GET"})
     */
    public function searchWorkoutBySport(WorkoutRepository $workoutRepository, SportsList $sport, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($workoutRepository->searchBySport(['sport' => $sport]), 'json', ['groups' => 'workout:display']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/search/team/{id}", name="app_search_team_sport", methods={"POST", "GET"})
     */
    public function searchTeamsBySport(TeamRepository $teamRepository, SerializerInterface $serializer, SportsList $sport)
    {
        $json = $serializer->serialize($teamRepository->searchBySport(['sport' => $sport]), 'json', ['groups' => 'search:team']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/search/team", name="app_search_team", methods={"POST", "GET"})
     */
    public function searchTeams(TeamRepository $teamRepository, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($teamRepository->findAll(), 'json', ['groups' => 'search:team']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/search/event", name="app_search_event", methods={"POST", "GET"})
     */
    public function searchEvents(EventRepository $eventRepository, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($eventRepository->findBy(['']), 'json', ['groups' => 'user:link']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
}

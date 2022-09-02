<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Entity\SportsList;
use App\Entity\User;
use App\Repository\EquipmentRepository;
use App\Repository\SportsListRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportListController extends AbstractController
{
    /**
     * @Route("/sports/", name="app_sport_list")
     */
    public function index(SportsListRepository $sportsListRepository): Response
    {
        return $this->render('sport_list/index.html.twig', [
            'controller_name' => 'SportListController',
            'sports' => $sportsListRepository->findBy([], ['name' => 'ASC'])
        ]);
    }
    /**
     * @Route("/sports/{id}", name="app_sport_show")
     */
    public function showSport(SportsList $sport, WorkoutRepository $workoutRepository,  TeamRepository $teamRepository, SportsListRepository $sportsListRepository, UserRepository $userRepository, EquipmentRepository $equipmentRepository): Response
    {
        $user = $this->getUser()->getUserIdentifier();
        $currentUser = $userRepository->findOneBy(['email' => $user]);
        $userSports = $currentUser->getSportlist();
        $sportId = $sport->getId();
        foreach ($userSports as $userSport) {
            $userSportsArray[] = $userSport->getId();
        }
        $remove = false;
        if (in_array($sportId, $userSportsArray)) {
            $remove = true;
        }
        dump($remove);
        return $this->render('sport_list/show.html.twig', [
            'controller_name' => 'SportListController',
            'equipments' => $equipmentRepository->searchBySport(['sportList' => $sport]),
            'sport' => $sport,
            'users' => $userRepository->searchBySport(['sportlist' => $sport], ['name' => 'ASC']),
            'teams' => $teamRepository->searchBySport(['sport' => $sport], ['name' => 'ASC']),
            'workouts' => $workoutRepository->searchBySport(['sport' => $sport]),
            'remove' => $remove
        ]);
    }
    /**
     * @Route("/add/{id},{sport}", name="app_sport_list_perso")
     * @ParamConverter("sportslist", options={"mapping"={"sport"="id"}})
     */
    public function addSportsPerso(EntityManagerInterface $em, SportsList $sportslist, User $user, UserRepository $userRepository, SportsListRepository $sportsListRepository)
    {
        $isPraticate = $user->getSportlist($sportslist);
        $sportslist->addUser($user);
        $user->addSportlist($sportslist);
        $em->persist($user, $sportslist);
        $em->flush();
        return $this->redirectToRoute('app_sport_show', ['id' => $sportslist->getId()], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/delete/{id}/{sport}", name="app_sport_list_remove", methods={"POST", "GET"})
     * @ParamConverter("sportslist", options={"mapping"={"sport"="id"}})
     */
    public function removeSportPerso(EntityManagerInterface $em, SportsList $sportslist, User $user)
    {

        $sportslist->removeUser($user);
        $user->removeSportlist($sportslist);
        $em->persist($user, $sportslist);
        $em->flush();
        return $this->redirectToRoute('app_sport_show', ['id' => $sportslist->getId()], Response::HTTP_SEE_OTHER);
    }
}

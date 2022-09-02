<?php

namespace App\Controller\User;

use App\Entity\Day;
use App\Entity\Program;
use App\Entity\Week;
use App\Entity\Workout;
use App\Form\ProgramType;
use App\Form\WeekType;
use App\Repository\DayRepository;
use App\Repository\MuscleGroupRepository;
use App\Repository\SportsListRepository;
use App\Repository\WeekRepository;
use App\Repository\WorkoutRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/program")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="app_user_program", methods={"GET"})
     */
    public function index(WeekRepository $weekRepository, MuscleGroupRepository $muscles, SportsListRepository $sportsListRepository): Response
    {
        $user = $this->getUser();
        return $this->render('user/program/index.html.twig', [
            'controller_name' => 'ProgramController',
            'monday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'monday']),
            'tuesday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'tuesday']),
            'wednesday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'wednesday']),
            'thursday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'thursday']),
            'friday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'friday']),
            'saturday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'saturday']),
            'sunday' => $weekRepository->findBy(['user' => $user, 'dayweek' => 'sunday']),
            'muscles' => $muscles->findAll([], ['name' => 'ASC']),
            'sportList' => $sportsListRepository->findBy([], ['name' => 'ASC'])

        ]);
    }
    /**
     * @Route("/monday/{workout}", name="app_user_program_monday", methods={"GET"})
     */
    public function monday(EntityManagerInterface $em, Workout $workout)
    {
        $user = $this->getUser();
        $week = new Week();
        $week->setUser($user);
        $week->setDayweek('monday');
        $week->setWorkout($workout);
        $em->persist($week);
        $em->flush();
        return $this->redirectToRoute('app_user_program');
    }
    /**
     * @Route("/tuesday/{workout}", name="app_user_program_tuesday", methods={"GET"})
     */
    public function tuesday(EntityManagerInterface $em, Workout $workout)
    {
        $user = $this->getUser();
        $week = new Week();
        $week->setUser($user);
        $week->setDayweek('tuesday');
        $week->setWorkout($workout);
        $em->persist($week);
        $em->flush();
        return $this->redirectToRoute('app_user_program');
    }
    /**
     * @Route("/wednesday/{workout}", name="app_user_program_wednesday", methods={"GET"})
     */
    public function wednesday(EntityManagerInterface $em, Workout $workout)
    {
        $user = $this->getUser();
        $week = new Week();
        $week->setUser($user);
        $week->setDayweek('wednesday');
        $week->setWorkout($workout);
        $em->persist($week);
        $em->flush();
        return $this->redirectToRoute('app_user_program');
    }
    /**
     * @Route("/thursday/{workout}", name="app_user_program_thursday", methods={"GET"})
     */
    public function thursday(EntityManagerInterface $em, Workout $workout)
    {
        $user = $this->getUser();
        $week = new Week();
        $week->setUser($user);
        $week->setDayweek('thursday');
        $week->setWorkout($workout);
        $em->persist($week);
        $em->flush();
        return $this->redirectToRoute('app_user_program');
    }
    /**
     * @Route("/friday/{workout}", name="app_user_program_friday", methods={"GET"})
     */
    public function friday(EntityManagerInterface $em, Workout $workout)
    {
        $user = $this->getUser();
        $week = new Week();
        $week->setUser($user);
        $week->setDayweek('friday');
        $week->setWorkout($workout);
        $em->persist($week);
        $em->flush();
        return $this->redirectToRoute('app_user_program');
    }
    /**
     * @Route("/saturday/{workout}", name="app_user_program_saturday", methods={"GET"})
     */
    public function saturday(EntityManagerInterface $em, Workout $workout)
    {
        $user = $this->getUser();
        $week = new Week();
        $week->setUser($user);
        $week->setDayweek('saturday');
        $week->setWorkout($workout);
        $em->persist($week);
        $em->flush();
        return $this->redirectToRoute('app_user_program');
    }
    /**
     * @Route("/sunday/{workout}", name="app_user_program_sunday", methods={"GET"})
     */
    public function sunday(EntityManagerInterface $em, Workout $workout)
    {
        $user = $this->getUser();
        $week = new Week();
        $week->setUser($user);
        $week->setDayweek('sunday');
        $week->setWorkout($workout);
        $em->persist($week);
        $em->flush();
        return $this->redirectToRoute('app_user_program');
    }
    /**
     * @Route("/delete/{id}", name="app_user_program_delete", methods={"POST", "GET"})
     */
    public function delete(Request $request, Week $week, WeekRepository $weekrepo): Response
    {
        $weekrepo->remove($week, true);

        return $this->redirectToRoute('app_user_program', [], Response::HTTP_SEE_OTHER);
    }
}

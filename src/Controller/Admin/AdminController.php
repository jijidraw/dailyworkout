<?php

namespace App\Controller\Admin;

use App\Entity\UserMedals;
use App\Repository\UserMedalsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin/medals", name="app_create_medals", methods={"GET"})
     */
    public function createDiaryUser(UserRepository $userRepository, EntityManagerInterface $em, UserMedalsRepository $medalsRepository)
    {
        $users = $userRepository->findAll();
        foreach ($users as $user) {
            $diary = new UserMedals();
            $diary->setUser($user)->setSilver(true)->setGold(true)->setBronze(true);
            $medalsRepository->add($diary, true);
            $em->persist($diary);
            $em->flush();
        }
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/admin/notes", name="app_create_notes", methods={"GET"})
     */
    public function regenNotes(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $users = $userRepository->findAll();
        foreach ($users as $user) {
            $user->setIsDiary(true);
            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
}

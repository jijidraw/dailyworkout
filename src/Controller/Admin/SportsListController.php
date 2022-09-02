<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\ImageSystem;
use App\Entity\SportsList;
use App\Form\SportsListType;
use App\Repository\ImageSystemRepository;
use App\Repository\SportsListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/sports/list")
 */
class SportsListController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_sports_list_index", methods={"GET"})
     */
    public function index(SportsListRepository $sportsListRepository): Response
    {
        return $this->render('admin/sports_list/index.html.twig', [
            'sports_lists' => $sportsListRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_sports_list_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SportsListRepository $sportsListRepository, EntityManagerInterface $em): Response
    {
        $sportsList = new SportsList();
        $form = $this->createForm(SportsListType::class, $sportsList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sportsListRepository->add($sportsList, true);
            $empty = $form->get('imageSystem')->getData();

            if (!empty($empty)) {

                $images = $form->get('imageSystem')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('sport_directory'),
                    $fichier
                );

                $img = new ImageSystem();
                $img->setName($fichier);
                $img->setSport($sportsList);
                $sportsList->setImageSystem($img);
            };

            $em->persist($sportsList);
            $em->flush();


            return $this->redirectToRoute('app_admin_sports_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/sports_list/new.html.twig', [
            'sports_list' => $sportsList,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_sports_list_show", methods={"GET"})
     */
    public function show(SportsList $sportsList): Response
    {
        return $this->render('admin/sports_list/show.html.twig', [
            'sports_list' => $sportsList,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_sports_list_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SportsList $sportsList, SportsListRepository $sportsListRepository, EntityManagerInterface $em, ImageSystemRepository $imageSystem): Response
    {
        $form = $this->createForm(SportsListType::class, $sportsList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sportsListRepository->add($sportsList, true);
            $empty = $form->get('imageSystem')->getData();

            if (!empty($empty)) {
                // fonction pour effacer l'ancienne image de profil
                $userId = $sportsList->getId();
                $ImgRmv = $imageSystem->findOneBy(['sport' => $userId]);
                $ImgRmvName = $ImgRmv->getName();
                unlink($this->getParameter('sport_directory') . '/' . $ImgRmvName);
                $em->remove($ImgRmv);
                $em->flush();

                $images = $form->get('imageSystem')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('sport_directory'),
                    $fichier
                );

                $img = new ImageSystem();
                $img->setName($fichier);
                $img->setSport($sportsList);
                $sportsList->setImageSystem($img);
            };
            $em->flush();

            return $this->redirectToRoute('app_admin_sports_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/sports_list/edit.html.twig', [
            'sports_list' => $sportsList,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_sports_list_delete", methods={"POST"})
     */
    public function delete(Request $request, SportsList $sportsList, SportsListRepository $sportsListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sportsList->getId(), $request->request->get('_token'))) {
            $sportsListRepository->remove($sportsList, true);
        }

        return $this->redirectToRoute('app_admin_sports_list_index', [], Response::HTTP_SEE_OTHER);
    }
}

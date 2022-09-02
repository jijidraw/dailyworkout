<?php

namespace App\Controller\Admin;

use App\Entity\Exercice;
use App\Entity\Images;
use App\Entity\ImageSystem;
use App\Form\ExerciceType;
use App\Repository\ExerciceRepository;
use App\Repository\ImageSystemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/exercice")
 */
class ExerciceController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_exercice_index", methods={"GET"})
     */
    public function index(ExerciceRepository $exerciceRepository): Response
    {
        return $this->render('admin/exercice/index.html.twig', [
            'exercices' => $exerciceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_exercice_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ExerciceRepository $exerciceRepository, EntityManagerInterface $em): Response
    {
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exerciceRepository->add($exercice, true);
            $empty = $form->get('imageSystem')->getData();

            if (!empty($empty)) {

                $images = $form->get('imageSystem')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('exercice_directory'),
                    $fichier
                );

                $img = new ImageSystem();
                $img->setName($fichier);
                $img->setExercice($exercice);
                $exercice->setImageSystem($img);
            };

            $em->persist($exercice);
            $em->flush();

            return $this->redirectToRoute('app_admin_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/exercice/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_exercice_show", methods={"GET"})
     */
    public function show(Exercice $exercice): Response
    {
        return $this->render('admin/exercice/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_exercice_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Exercice $exercice, ExerciceRepository $exerciceRepository, EntityManagerInterface $em, ImageSystemRepository $imageSystem): Response
    {
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exerciceRepository->add($exercice, true);
            $empty = $form->get('imageSystem')->getData();

            if (!empty($empty)) {
                // fonction pour effacer l'ancienne image
                $userId = $exercice->getId();
                $ImgRmv = $imageSystem->findOneBy(['exercice' => $userId]);
                $ImgRmvName = $ImgRmv->getName();
                unlink($this->getParameter('exercice_directory') . '/' . $ImgRmvName);
                $em->remove($ImgRmv);
                $em->flush();

                $images = $form->get('imageSystem')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('exercice_directory'),
                    $fichier
                );

                $img = new ImageSystem();
                $img->setName($fichier);
                $img->setExercice($exercice);
                $exercice->setImageSystem($img);
            };
            $em->flush();

            return $this->redirectToRoute('app_admin_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/exercice/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_exercice_delete", methods={"POST"})
     */
    public function delete(Request $request, Exercice $exercice, ExerciceRepository $exerciceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $exercice->getId(), $request->request->get('_token'))) {
            $exerciceRepository->remove($exercice, true);
        }

        return $this->redirectToRoute('app_admin_exercice_index', [], Response::HTTP_SEE_OTHER);
    }
}

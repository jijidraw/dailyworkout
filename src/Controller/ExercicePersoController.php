<?php

namespace App\Controller;

use App\Entity\ExercicePerso;
use App\Form\ExercicePerso1Type;
use App\Repository\ExercicePersoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/exercice/perso")
 */
class ExercicePersoController extends AbstractController
{
    /**
     * @Route("/", name="app_exercice_perso_index", methods={"GET"})
     */
    public function index(ExercicePersoRepository $exercicePersoRepository): Response
    {
        return $this->render('exercice_perso/index.html.twig', [
            'exercice_persos' => $exercicePersoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_exercice_perso_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ExercicePersoRepository $exercicePersoRepository): Response
    {
        $exercicePerso = new ExercicePerso();
        $form = $this->createForm(ExercicePerso1Type::class, $exercicePerso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exercicePersoRepository->add($exercicePerso, true);

            return $this->redirectToRoute('app_exercice_perso_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exercice_perso/new.html.twig', [
            'exercice_perso' => $exercicePerso,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_exercice_perso_show", methods={"GET"})
     */
    public function show(ExercicePerso $exercicePerso): Response
    {
        return $this->render('exercice_perso/show.html.twig', [
            'exercice_perso' => $exercicePerso,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_exercice_perso_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ExercicePerso $exercicePerso, ExercicePersoRepository $exercicePersoRepository): Response
    {
        $form = $this->createForm(ExercicePerso1Type::class, $exercicePerso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exercicePersoRepository->add($exercicePerso, true);

            return $this->redirectToRoute('app_exercice_perso_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exercice_perso/edit.html.twig', [
            'exercice_perso' => $exercicePerso,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_exercice_perso_delete", methods={"POST"})
     */
    public function delete(Request $request, ExercicePerso $exercicePerso, ExercicePersoRepository $exercicePersoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercicePerso->getId(), $request->request->get('_token'))) {
            $exercicePersoRepository->remove($exercicePerso, true);
        }

        return $this->redirectToRoute('app_exercice_perso_index', [], Response::HTTP_SEE_OTHER);
    }
}

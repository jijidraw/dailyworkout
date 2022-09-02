<?php

namespace App\Controller\Admin;

use App\Entity\Difficulty;
use App\Form\Difficulty1Type;
use App\Repository\DifficultyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/difficulty')]
class DifficultyController extends AbstractController
{
    #[Route('/', name: 'app_admin_difficulty_index', methods: ['GET'])]
    public function index(DifficultyRepository $difficultyRepository): Response
    {
        return $this->render('admin/difficulty/index.html.twig', [
            'difficulties' => $difficultyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_difficulty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DifficultyRepository $difficultyRepository): Response
    {
        $difficulty = new Difficulty();
        $form = $this->createForm(Difficulty1Type::class, $difficulty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $difficultyRepository->add($difficulty, true);

            return $this->redirectToRoute('app_admin_difficulty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/difficulty/new.html.twig', [
            'difficulty' => $difficulty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_difficulty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Difficulty $difficulty, DifficultyRepository $difficultyRepository): Response
    {
        $form = $this->createForm(Difficulty1Type::class, $difficulty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $difficultyRepository->add($difficulty, true);

            return $this->redirectToRoute('app_admin_difficulty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/difficulty/edit.html.twig', [
            'difficulty' => $difficulty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_difficulty_delete', methods: ['POST'])]
    public function delete(Request $request, Difficulty $difficulty, DifficultyRepository $difficultyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $difficulty->getId(), $request->request->get('_token'))) {
            $difficultyRepository->remove($difficulty, true);
        }

        return $this->redirectToRoute('app_admin_difficulty_index', [], Response::HTTP_SEE_OTHER);
    }
}

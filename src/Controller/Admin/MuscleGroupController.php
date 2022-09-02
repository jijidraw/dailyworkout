<?php

namespace App\Controller\Admin;

use App\Entity\MuscleGroup;
use App\Form\MuscleGroup1Type;
use App\Repository\MuscleGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/muscle/group')]
class MuscleGroupController extends AbstractController
{
    #[Route('/', name: 'app_admin_muscle_group_index', methods: ['GET'])]
    public function index(MuscleGroupRepository $muscleGroupRepository): Response
    {
        return $this->render('admin/muscle_group/index.html.twig', [
            'muscle_groups' => $muscleGroupRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_muscle_group_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MuscleGroupRepository $muscleGroupRepository): Response
    {
        $muscleGroup = new MuscleGroup();
        $form = $this->createForm(MuscleGroup1Type::class, $muscleGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $muscleGroupRepository->add($muscleGroup, true);

            return $this->redirectToRoute('app_admin_muscle_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/muscle_group/new.html.twig', [
            'muscle_group' => $muscleGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_muscle_group_show', methods: ['GET'])]
    public function show(MuscleGroup $muscleGroup): Response
    {
        return $this->render('admin/muscle_group/show.html.twig', [
            'muscle_group' => $muscleGroup,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_muscle_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MuscleGroup $muscleGroup, MuscleGroupRepository $muscleGroupRepository): Response
    {
        $form = $this->createForm(MuscleGroup1Type::class, $muscleGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $muscleGroupRepository->add($muscleGroup, true);

            return $this->redirectToRoute('app_admin_muscle_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/muscle_group/edit.html.twig', [
            'muscle_group' => $muscleGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_muscle_group_delete', methods: ['POST'])]
    public function delete(Request $request, MuscleGroup $muscleGroup, MuscleGroupRepository $muscleGroupRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$muscleGroup->getId(), $request->request->get('_token'))) {
            $muscleGroupRepository->remove($muscleGroup, true);
        }

        return $this->redirectToRoute('app_admin_muscle_group_index', [], Response::HTTP_SEE_OTHER);
    }
}

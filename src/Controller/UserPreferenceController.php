<?php

namespace App\Controller;

use App\Entity\UserPreference;
use App\Form\UserPreferenceType;
use App\Repository\UserPreferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/preference')]
class UserPreferenceController extends AbstractController
{
    #[Route('/', name: 'app_user_preference_index', methods: ['GET'])]
    public function index(UserPreferenceRepository $userPreferenceRepository): Response
    {
        return $this->render('user_preference/index.html.twig', [
            'user_preferences' => $userPreferenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_preference_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPreferenceRepository $userPreferenceRepository): Response
    {
        $user = $this->getUser();
        $userPreference = new UserPreference();
        $form = $this->createForm(UserPreferenceType::class, $userPreference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userPreference->setUser($user);
            $userPreferenceRepository->add($userPreference, true);

            return $this->redirectToRoute('app_diary_note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_preference/new.html.twig', [
            'user_preference' => $userPreference,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_preference_show', methods: ['GET'])]
    public function show(UserPreference $userPreference): Response
    {
        return $this->render('user_preference/show.html.twig', [
            'user_preference' => $userPreference,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_preference_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserPreference $userPreference, UserPreferenceRepository $userPreferenceRepository): Response
    {
        $form = $this->createForm(UserPreferenceType::class, $userPreference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userPreferenceRepository->add($userPreference, true);

            return $this->redirectToRoute('app_diary_note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_preference/edit.html.twig', [
            'user_preference' => $userPreference,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_preference_delete', methods: ['POST'])]
    public function delete(Request $request, UserPreference $userPreference, UserPreferenceRepository $userPreferenceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userPreference->getId(), $request->request->get('_token'))) {
            $userPreferenceRepository->remove($userPreference, true);
        }

        return $this->redirectToRoute('app_user_preference_index', [], Response::HTTP_SEE_OTHER);
    }
}

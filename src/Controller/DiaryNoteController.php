<?php

namespace App\Controller;

use App\Entity\DiaryNote;
use App\Entity\Images;
use App\Entity\UserPreference;
use App\Form\DiaryNoteType;
use App\Repository\DiaryNoteRepository;
use App\Repository\DiaryRepository;
use App\Repository\ImagesRepository;
use App\Repository\UserPreferenceRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/diarynote')]
class DiaryNoteController extends AbstractController
{
    #[Route('/', name: 'app_diary_note_index', methods: ['GET'])]
    public function index(DiaryNoteRepository $diaryNoteRepository, UserPreferenceRepository $userPreferenceRepository): Response
    {
        $month = date('F');
        $year = date('o');
        $user = $this->getUser();
        $userPreference = $userPreferenceRepository->findOneBy(['user' => $user]);
        if (!isset($userPreference)) {
            return $this->redirectToRoute('app_user_preference_new');
        }
        $notes = $diaryNoteRepository->findBy(['user' => $user], ['id' => 'DESC']);
        $cheatmeal = $diaryNoteRepository->count(['user' => $user, 'cheatmeal' => false, 'month' => $month, 'year' => $year]);
        $healthy = $diaryNoteRepository->count(['user' => $user, 'cheatmeal' => true, 'month' => $month, 'year' => $year]);
        $alcool = $diaryNoteRepository->count(['user' => $user, 'alcool' => true, 'month' => $month, 'year' => $year]);
        $training = $diaryNoteRepository->count(['user' => $user, 'training' => true, 'month' => $month, 'year' => $year]);
        $rest = $diaryNoteRepository->count(['user' => $user, 'training' => false, 'month' => $month, 'year' => $year]);
        $meditation = $diaryNoteRepository->count(['user' => $user, 'is_meditation' => true, 'month' => $month, 'year' => $year]);
        $water = $diaryNoteRepository->count(['user' => $user, 'is_water' => true, 'month' => $month, 'year' => $year]);
        // $tabac = $diaryNoteRepository->count(['user' => $user, 'tabac' => true, 'month' => $month, 'year' => $year]);


        return $this->render('diary_note/index.html.twig', [
            'notes' => $notes,
            'preference' => $userPreference,
            'healthy' => $healthy,
            'meditation' => $meditation,
            'alcool' => $alcool,
            'water' => $water,
            'training' => $training,
            'cheatmeal' => $cheatmeal,
            // 'tabac' => $tabac,
            'rest' => $rest,
        ]);
    }

    #[Route('/new', name: 'app_diary_note_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, DiaryNoteRepository $diaryNoteRepository, UserRepository $userRepository, UserPreferenceRepository $userPreferenceRepository): Response
    {
        $users = $this->getUser()->getUserIdentifier();
        $user = $userRepository->findOneBy(['email' => $users]);
        $month = date('F');
        $year = date('o');
        $userPreference = $userPreferenceRepository->findOneBy(['user' => $user]);

        $diaryNote = new DiaryNote();
        $form = $this->createForm(DiaryNoteType::class, $diaryNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsDiary(false);
            $userRepository->add($user, true);
            $diaryNote->setCreatedAt(new DateTime())->setUser($user)->setMonth($month)->setYear($year);
            $diaryNoteRepository->add($diaryNote, true);
            $empty = $form->get('images')->getData();

            if (!empty($empty)) {

                $images = $form->get('images')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('post_directory'),
                    $fichier
                );

                $img = new Images();
                $img->setName($fichier);
                $img->setDiary($diaryNote);
                $diaryNote->setImages($img);
            };

            $em->persist($diaryNote);
            $em->flush();

            return $this->redirectToRoute('app_diary_note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diary_note/new.html.twig', [
            'diary_note' => $diaryNote,
            'form' => $form,
            'preference' => $userPreference
        ]);
    }

    #[Route('/{id}', name: 'app_diary_note_show', methods: ['GET'])]
    public function show(DiaryNote $diaryNote): Response
    {
        return $this->render('diary_note/show.html.twig', [
            'diary_note' => $diaryNote,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_diary_note_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DiaryNote $diaryNote, ImagesRepository $imagesRepository, DiaryNoteRepository $diaryNoteRepository, EntityManagerInterface $em, UserPreferenceRepository $userPreferenceRepository): Response
    {
        $form = $this->createForm(DiaryNoteType::class, $diaryNote);
        $form->handleRequest($request);
        $user = $this->getUser();
        $userPreference = $userPreferenceRepository->findOneBy(['user' => $user]);

        if ($form->isSubmitted() && $form->isValid()) {
            $diaryNoteRepository->add($diaryNote, true);
            $empty = $form->get('images')->getData();

            if (!empty($empty)) {

                $ImgRmv = $imagesRepository->findOneBy(['diary' => $diaryNote]);
                if (!empty($ImgRmv)) {
                    $ImgRmvName = $ImgRmv->getName();
                    unlink($this->getParameter('post_directory') . '/' . $ImgRmvName);
                    $em->remove($ImgRmv);
                    $em->flush();
                }

                $images = $form->get('images')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('post_directory'),
                    $fichier
                );

                $img = new Images();
                $img->setName($fichier);
                $img->setDiary($diaryNote);
                $diaryNote->setImages($img);
            };

            $em->persist($diaryNote);
            $em->flush();

            return $this->redirectToRoute('app_diary_note_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('diary_note/edit.html.twig', [
            'diary_note' => $diaryNote,
            'form' => $form,
            'preference' => $userPreference
        ]);
    }

    #[Route('/{id}', name: 'app_diary_note_delete', methods: ['POST'])]
    public function delete(Request $request, DiaryNote $diaryNote, DiaryNoteRepository $diaryNoteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $diaryNote->getId(), $request->request->get('_token'))) {
            $diaryNoteRepository->remove($diaryNote, true);
        }

        return $this->redirectToRoute('app_diary_note_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller\User;

use App\Entity\Category;
use App\Entity\Exercice;
use App\Entity\ExercicePerso;
use App\Entity\MuscleGroup;
use App\Entity\SportsList;
use App\Entity\User;
use App\Entity\Workout;
use App\Entity\WorkoutFav;
use App\Entity\WorkoutNotation;
use App\Form\Workout1Type;
use App\Form\WorkoutType;
use App\Repository\CategoryRepository;
use App\Repository\ExercicePersoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\ExerciceRepository;
use App\Repository\MuscleGroupRepository;
use App\Repository\SportsListRepository;
use App\Repository\UserStatRepository;
use App\Repository\WorkoutNotationRepository;
use App\Repository\WorkoutRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/workout")
 */
class WorkoutController extends AbstractController
{
    /**
     * @Route("/", name="app_workout_index", methods={"GET"})
     */
    public function index(WorkoutRepository $workoutRepository): Response
    {
        return $this->render('user/workout/index.html.twig', [
            'workouts' => $workoutRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="app_workout_new", methods={"GET", "POST"})
     */
    public function new(UserStatRepository $userStatRepository, Request $request, WorkoutRepository $workoutRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $workout = new Workout();
        $form = $this->createForm(WorkoutType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userStat = $userStatRepository->findOneBy(['user' => $user]);
            $count = $userStat->getWorkout();
            $userStat->setWorkout(++$count);
            $userStatRepository->add($userStat, true);
            $workoutRepository->add($workout, true);
            $workout->setUser($user);
            $em->persist($workout);
            $em->flush();

            return $this->redirectToRoute('app_workout_new_step_2', ['id' => $workout->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/workout/new.html.twig', [
            'workout' => $workout,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/new/step2/{id}", name="app_workout_new_step_2", methods={"GET", "POST"})
     */
    public function newWorkoutStep2(Request $request, SportsListRepository $sportsListRepository, Workout $workout, CategoryRepository $categoryRepository, MuscleGroupRepository $muscleGroupRepository, ExerciceRepository $exerciceRepository): Response
    {
        $user = $this->getUser();
        $creator = $workout->getUser();
        if ($user != $creator) {
            return $this->redirectToRoute('app_workout_show', ['id' => $workout->getId()], Response::HTTP_SEE_OTHER);
        };
        $Lists = $workout->getSport();
        foreach ($Lists as $list) {
            $selecs = $exerciceRepository->searchBySport($list);
            foreach ($selecs as $selec) {
                $selection[] = $selec;
                $selections = array_map("unserialize", array_unique(array_map("serialize", $selection)));
            }
        }
        if (!isset($selections)) {
            $selections = $exerciceRepository->findBy([], ['id' => 'DESC']);
        }

        $fCategory = $request->get("category");
        $fMuscles = $request->get("muscles");
        $fSports = $request->get("sports");

        // variable envoyé à la vue
        $exercices = $exerciceRepository->exercicesFilters($fCategory, $fMuscles, $fSports);
        $category = $categoryRepository->findBy([], ['name' => 'ASC']);
        $sports = $sportsListRepository->findBy([], ['name' => 'ASC']);
        $muscles = $muscleGroupRepository->findBy([], ['name' => 'ASC']);


        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('user/workout/_content_step2.html.twig', compact('workout', 'exercices', 'category', 'sports', 'muscles'))
            ]);
        }

        return $this->render('user/workout/new_step_2.html.twig', compact('workout', 'exercices', 'category', 'sports', 'muscles', 'selections', 'Lists'));
    }

    /**
     * @Route("/{workout}/edit", name="app_workout_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Workout $workout, WorkoutRepository $workoutRepository, SportsListRepository $sportsListRepository, CategoryRepository $categoryRepository, ExerciceRepository $exrepo, MuscleGroupRepository $muscleGroupRepository, ExercicePersoRepository $experso): Response
    {
        $form = $this->createForm(Workout1Type::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workoutRepository->add($workout, true);

            return $this->redirectToRoute('app_user_program', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/workout/edit.html.twig', [
            'workout' => $workout,
            'form' => $form,
            'ListExercice' => $exrepo->findAll(),
            'category' => $categoryRepository->findBy([], ['name' => 'ASC']),
            'sports' => $sportsListRepository->findBy([], ['name' => 'ASC']),
            'muscles' => $muscleGroupRepository->findBy([], ['name' => 'ASC']),
            'experso' => $experso->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="app_workout_show", methods={"GET"})
     */
    public function show(Workout $workout, WorkoutNotationRepository $workoutNotationRepository): Response
    {
        $user = $this->getUser();
        $userNote = $workoutNotationRepository->findOneBy(['user' => $user, 'workout' => $workout]);
        $notations = $workoutNotationRepository->findBy(['workout' => $workout]);
        $voters = count($notations);
        foreach ($notations as $notation) {
            $sum[] = $notation->getNote();
            $moyennes = array_sum($sum);
        }
        if (!empty($voters)) {
            $mean = $moyennes / $voters;
        } else {
            $mean = 0;
        }

        return $this->render('user/workout/show.html.twig', [
            'workout' => $workout,
            'userNote' => $userNote,
            'notations' => $notations,
            'mean' => $mean
        ]);
    }
    /**
     * @Route("/{id}/duplicate", name="app_workout_duplicate", methods={"GET"})
     */
    public function modifierForUser(Workout $workout, WorkoutRepository $workoutRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        // on copie les données du workout à dupliquer
        $wName = $workout->getName();
        $wContent = $workout->getContent();
        $wLevel = $workout->getLevel();
        $wRound = $workout->getRounds();

        $wMuscles = $workout->getMuscleGroup();
        $wSports = $workout->getSport();
        $wExercices = $workout->getExercicePersos();
        // le nouveau workout
        $workoutDuplicate = new Workout();
        $workoutDuplicate->setUser($user)->setCreatedAt(new DateTime());
        if ($wContent != null) {
            $workoutDuplicate->setContent($wContent);
        }
        if ($wLevel != null) {
            $workoutDuplicate->setLevel($wLevel);
        }
        if ($wRound != null) {
            $workoutDuplicate->setRounds($wRound);
        }
        if ($wName != null) {
            $workoutDuplicate->setName($wName);
        }
        $em->persist($workoutDuplicate);
        $em->flush();
        if ($wMuscles != null) {
            foreach ($wMuscles as $wMuscle) {
                $workoutDuplicate->addMuscleGroup($wMuscle);
                $workoutRepository->add($workoutDuplicate, true);
            }
        }
        if ($wSports != null) {
            foreach ($wSports as $wSport) {
                $workoutDuplicate->addSport($wSport);
                $workoutRepository->add($workoutDuplicate, true);
            }
        }
        if ($wExercices != null) {
            foreach ($wExercices as $wExercice) {
                $experso = new ExercicePerso();
                $exercice = $wExercice->getExercice();
                $effort = $wExercice->getEffortType();
                $quantity = $wExercice->getQuantity();
                $content = $wExercice->getContent();
                $rest = $wExercice->getRest();
                if ($effort != null) {
                    $experso->setEffortType($effort);
                }
                if ($quantity != null) {
                    $experso->setQuantity($quantity);
                }
                if ($content != null) {
                    $experso->setContent($content);
                }
                if ($rest != null) {
                    $experso->setRest($rest);
                }
                $experso->setExercice($exercice)->setWorkout($workoutDuplicate);
                $em->persist($experso);
                $em->flush();
            }
        }

        return $this->redirectToRoute('app_workout_edit', ['workout' => $workoutDuplicate->getId()], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/add/{id}/{workout}", name="app_workout_perso", methods={"POST", "GET"})
     * @ParamConverter("workout", options={"mapping"={"workout"="id"}})
     */
    public function exerciceperso(EntityManagerInterface $em, Exercice $exercice, Workout $workout, ExerciceRepository $exerciceRepository, SerializerInterface $serializerInterface, WorkoutRepository $workoutRepository)
    {
        $ExPerso = new ExercicePerso();
        $ExPerso->setExercice($exercice);
        $ExPerso->setWorkout($workout);
        $em->persist($ExPerso);
        $em->flush();
        $muscles = $exercice->getMuscleGroup();
        foreach ($muscles as $muscle) {
            $workout->addMuscleGroup($muscle);
            $workoutRepository->add($workout, true);
        }
        $json = $serializerInterface->serialize($ExPerso, 'json', ['groups' => 'workout:display']);
        // $json = $serializerInterface->serialize($exerciceRepository->findOneBy(['id' => $exerciceId]), 'json', ['groups' => 'exercice:detail', 'exoId' => $exPersoId]);

        $response = new Response(
            $json,
            200,
            [
                "Content-Type" => "application/json",
            ]
        );
        return $response;
    }
    /**
     * @Route("/adding/{id}/{workout}", name="app_workout_perso_adding", methods={"POST", "GET"})
     * @ParamConverter("workout", options={"mapping"={"workout"="id"}})
     */
    public function exercicepersoAdd(Request $request, EntityManagerInterface $em, Exercice $exercice, Workout $workout, ExerciceRepository $exerciceRepository, WorkoutRepository $workoutRepository)
    {
        $route = $request->headers->get('referer');
        $ExPerso = new ExercicePerso();
        $ExPerso->setExercice($exercice);
        $ExPerso->setWorkout($workout);
        $em->persist($ExPerso);
        $em->flush();
        $muscles = $exercice->getMuscleGroup();
        foreach ($muscles as $muscle) {
            $workout->addMuscleGroup($muscle);
            $workoutRepository->add($workout, true);
        }
        $this->addFlash('success', 'Exercices ajouté');
        return $this->redirect($route);
    }
    /**
     * @Route("/delete/exercice/{id}", name="app_workout_perso_delete", methods={"GET", "POST"})
     */
    public function exercicepersoDelete(ExercicePersoRepository $exerciceRepository, ExercicePerso $exercicePerso, Request $request): Response
    {
        $route = $request->headers->get('referer');
        $exerciceRepository->remove($exercicePerso, true);
        $this->addFlash('success', 'Exercices retiré');

        return $this->redirect($route);
    }

    /**
     * @Route("/{id}", name="app_workout_delete", methods={"POST","GET"})
     */
    public function delete(Request $request, Workout $workout, WorkoutRepository $workoutRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $workout->getId(), $request->request->get('_token'))) {
            $workoutRepository->remove($workout, true);
        }

        return $this->redirectToRoute('app_user_program');
    }
    /**
     * @Route("/category/{id}", name="app_workout_category", methods={"POST","GET"})
     */
    public function getExerciceByCategory(Category $category, ExerciceRepository $exerciceRepository, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($exerciceRepository->searchByCategory(['categories' => $category]), 'json', ['groups' => 'exercice:category']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/muscle/{id}", name="app_workout_muscle", methods={"POST","GET"})
     */
    public function getExerciceByMuscle(MuscleGroup $muscle, ExerciceRepository $exerciceRepository, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($exerciceRepository->searchByMuscle(['muscleGroup' => $muscle]), 'json', ['groups' => 'exercice:category']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/sport/{id}", name="app_workout_sport", methods={"POST","GET"})
     */
    public function getExerciceBySport(SportsList $sport, ExerciceRepository $exerciceRepository, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($exerciceRepository->searchBySport(['sports' => $sport]), 'json', ['groups' => 'exercice:category']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);
        return $response;
    }
    /**
     * @Route("/note1/{id}", name="app_workout_note1", methods={"GET"})
     */
    public function setWorkoutNote1(Workout $workout, WorkoutNotationRepository $workoutNotationRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $workoutNote = $workoutNotationRepository->findOneBy(['user' => $user, 'workout' => $workout]);
        if (!empty($workoutNote)) {
            $workoutNote->setNote(1);
            $workoutNotationRepository->add($workoutNote, true);
        } else {
            $note = new WorkoutNotation();
            $note->setUser($user)->setWorkout($workout)->setNote(1);
            $em->persist($note);
            $em->flush();
        }
        return $this->json([
            'code' => 200,
            'message' => 'Vote pris en compte'
        ], 200);
    }
    /**
     * @Route("/note2/{id}", name="app_workout_note2", methods={"GET"})
     */
    public function setWorkoutNote2(Workout $workout, WorkoutNotationRepository $workoutNotationRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $workoutNote = $workoutNotationRepository->findOneBy(['user' => $user, 'workout' => $workout]);
        if (!empty($workoutNote)) {
            $workoutNote->setNote(2);
            $workoutNotationRepository->add($workoutNote, true);
        } else {
            $note = new WorkoutNotation();
            $note->setUser($user)->setWorkout($workout)->setNote(1);
            $em->persist($note);
            $em->flush();
        }
        return $this->json([
            'code' => 200,
            'message' => 'Vote pris en compte'
        ], 200);
    }
    /**
     * @Route("/note3/{id}", name="app_workout_note3", methods={"GET"})
     */
    public function setWorkoutNote3(Workout $workout, WorkoutNotationRepository $workoutNotationRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $workoutNote = $workoutNotationRepository->findOneBy(['user' => $user, 'workout' => $workout]);
        if (!empty($workoutNote)) {
            $workoutNote->setNote(3);
            $workoutNotationRepository->add($workoutNote, true);
        } else {
            $note = new WorkoutNotation();
            $note->setUser($user)->setWorkout($workout)->setNote(3);
            $em->persist($note);
            $em->flush();
        }
        return $this->json([
            'code' => 200,
            'message' => 'Vote pris en compte'
        ], 200);
    }
    /**
     * @Route("/note4/{id}", name="app_workout_note4", methods={"GET"})
     */
    public function setWorkoutNote4(Workout $workout, WorkoutNotationRepository $workoutNotationRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $workoutNote = $workoutNotationRepository->findOneBy(['user' => $user, 'workout' => $workout]);
        if (!empty($workoutNote)) {
            $workoutNote->setNote(4);
            $workoutNotationRepository->add($workoutNote, true);
        } else {
            $note = new WorkoutNotation();
            $note->setUser($user)->setWorkout($workout)->setNote(1);
            $em->persist($note);
            $em->flush();
        }
        return $this->json([
            'code' => 200,
            'message' => 'Vote pris en compte'
        ], 200);
    }
    /**
     * @Route("/note5/{id}", name="app_workout_note5", methods={"GET"})
     */
    public function setWorkoutNote5(Workout $workout, WorkoutNotationRepository $workoutNotationRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $workoutNote = $workoutNotationRepository->findOneBy(['user' => $user, 'workout' => $workout]);
        if (!empty($workoutNote)) {
            $workoutNote->setNote(5);
            $workoutNotationRepository->add($workoutNote, true);
        } else {
            $note = new WorkoutNotation();
            $note->setUser($user)->setWorkout($workout)->setNote(5);
            $em->persist($note);
            $em->flush();
        }
        return $this->json([
            'code' => 200,
            'message' => 'Vote pris en compte'
        ], 200);
    }
}

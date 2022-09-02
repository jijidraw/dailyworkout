<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventParticipate;
use App\Entity\Images;
use App\Entity\ImagesProfiles;
use App\Entity\PostEvent;
use App\Form\EventPostType;
use App\Form\EventType;
use App\Repository\EventParticipateRepository;
use App\Repository\EventRepository;
use App\Repository\ImagesProfilesRepository;
use App\Repository\PostEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="app_event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        $user = $this->getUser();
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->eventByUser(['present' => $user]),
        ]);
    }

    /**
     * @Route("/new", name="app_event_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EventRepository $eventRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setCreator($user);
            $event->addPresent($user);
            $eventRepository->add($event, true);

            $empty = $form->get('imageProfile')->getData();

            if (!empty($empty)) {

                $images = $form->get('imageProfile')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('profil_directory'),
                    $fichier
                );

                $img = new ImagesProfiles();
                $img->setName($fichier);
                $img->setEvent($event);
                $event->setImagesProfiles($img);
            };

            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_event_show", methods={"GET", "POST"})
     */
    public function show(Event $event, EventRepository $eventRepository, Request $request, PostEventRepository $postEventRepository, EntityManagerInterface $em): Response
    {
        $eventPost = new PostEvent();
        $postForm = $this->createForm(EventPostType::class, $eventPost);
        $postForm->handleRequest($request);
        $user = $this->getUser();


        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $eventPost->setUser($user)->setEvent($event);
            $empty = $postForm->get('images')->getData();
            $postEventRepository->add($eventPost, true);

            if (!empty($empty)) {
                $images = $postForm->get('images')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('post_directory'),
                    $fichier
                );
                $img = new Images();
                $img->setName($fichier);
                $eventPost->addImage($img);
            };
            $em->persist($eventPost);
            $em->flush();

            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/show.html.twig', [
            'events' => $eventRepository->eventByUser(['present' => $user]),
            'posts' => $postEventRepository->findBy(['event' => $event]),
            'form' => $postForm->createView(),
            'event' => $event
        ]);
    }

    /**
     * @Route("/{id}/participate", name="app_event_participate", methods={"GET"})
     */
    public function participate(Event $event, EventParticipateRepository $eventParticipateRepository)
    {
        $user = $this->getUser();
        $eventParticipate = new EventParticipate();
        $eventParticipate->setUser($user)->setEvent($event);
        $eventParticipateRepository->add($eventParticipate, true);

        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/edit", name="app_event_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Event $event, EventRepository $eventRepository, EntityManagerInterface $em, ImagesProfilesRepository $imagesProfilesRepository): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $empty = $form->get('imageProfile')->getData();

            if (!empty($empty)) {
                // fonction pour effacer l'ancienne image de profil

                $userId = $event->getId();
                $ImgRmv = $imagesProfilesRepository->findOneBy(['event' => $userId]);
                if (!empty($ImgRmv)) {
                    $ImgRmvName = $ImgRmv->getName();
                    unlink($this->getParameter('profil_directory') . '/' . $ImgRmvName);
                    $em->remove($ImgRmv);
                    $em->flush();
                }

                // enregistrement de la nouvelle image

                $images = $form->get('imageProfile')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('profil_directory'),
                    $fichier
                );
                $img = new ImagesProfiles();
                $img->setName($fichier);
                $img->setEvent($event);
                $event->setImagesProfiles($img);
            };

            $eventRepository->add($event, true);

            return $this->redirectToRoute('app_event_show', ['id' => $event->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            if ($event->getImagesProfiles() != null) {
                $imgName = $event->getImagesProfiles()->getName();
                unlink($this->getParameter('profil_directory') . '/' . $imgName);
            }

            $eventRepository->remove($event, true);
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }
}

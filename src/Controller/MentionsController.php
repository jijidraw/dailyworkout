<?php

namespace App\Controller;

use App\Entity\ContactEmail;
use App\Entity\User;
use App\Form\ContactEmailType;
use App\Form\User2Type;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class MentionsController extends AbstractController
{
    /**
     * @Route("/mentions", name="app_mentions")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('mentions/index.html.twig', [
            'controller_name' => 'MentionsController',
            'user' => $user
        ]);
    }
    /**
     * @Route("/reglement", name="app_reglement")
     */
    public function reglement(): Response
    {
        $user = $this->getUser();
        return $this->render('mentions/reglement.html.twig', [
            'controller_name' => 'MentionsController',
            'user' => $user
        ]);
    }
    /**
     * @Route("/politique", name="app_politique")
     */
    public function politique(): Response
    {
        $user = $this->getUser();
        return $this->render('mentions/politique.html.twig', [
            'controller_name' => 'MentionsController',
            'user' => $user
        ]);
    }
    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $user = $this->getUser();

        $contact = new ContactEmail();
        $form = $this->createForm(ContactEmailType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contact);
            $em->flush();
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('thedailyworkoutofficial@gmail.com')
                ->subject($contact->getSubject())
                ->htmlTemplate('emails/contact.html.twig')
                ->context(compact('contact'));
        }
        return $this->render('mentions/contact.html.twig', [
            'controller_name' => 'MentionsController',
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
    /**
     * @Route("/parameter/{id}", name="app_user_system", methods={"GET", "POST"})
     */
    public function userSystem(Request $request, User $user, UserRepository $userRepository): Response
    {
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $userId = $currentName->getId();
        if ($userId != $user->getId()) {
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }

        $form = $this->createForm(User2Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        };


        return $this->renderForm('user/user/parameter.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}

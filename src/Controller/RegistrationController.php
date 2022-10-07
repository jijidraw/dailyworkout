<?php

namespace App\Controller;

use App\Entity\Follow;
use App\Entity\ImagesProfiles;
use App\Entity\Notification;
use App\Entity\Reward;
use App\Entity\User;
use App\Entity\UserMedals;
use App\Entity\UserStat;
use App\Form\RegistrationFormType;
use App\Repository\RewardRepository;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security\UserAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager, RewardRepository $rewardRepository, UserRepository $userRepository): Response
    {
        $daily = $userRepository->findOneBy(['email' => 'thedailyworkoutofficial@gmail.com']);
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsWelcome(true)->setIsPrivate(false)->setIsUnactive(false);

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $img = new ImagesProfiles;
            $img->setUser($user)->setName('login.png');
            $entityManager->persist($img);
            $entityManager->flush();
            $medals = new UserMedals;
            $medals->setGold(true)->setBronze(true)->setSilver(true);
            $entityManager->persist($medals);
            $entityManager->flush();
            $rewardId = $rewardRepository->findOneBy(['id' => '1']);
            $user->addReward($rewardId)->setImagesProfiles($img);
            $entityManager->persist($user);
            $entityManager->flush();
            $userStat = new UserStat();
            $userStat->setUser($user);
            $entityManager->persist($userStat);
            $entityManager->flush();
            $notification = new Notification();
            $notification->setUser($user)->setContent("Bienvenue sur Daily Workout")->setImage('logo.png')->setIsRead(false);
            $entityManager->persist($notification);
            $entityManager->flush();
            $follow = new Follow;
            $follow->setFollower($user)->setFollowing($daily);
            $entityManager->persist($follow);
            $entityManager->flush();                // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@the-daily-workout.com', 'The Daily Workout'))
                    ->to($user->getEmail())
                    ->subject('Confirmez votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
            // $this->addFlash('success', 'Veuillez vérifier vos mails pour valider votre inscription, pensez à vérifier dans les spams');
            // return $userAuthenticator->authenticateUser(
            //     $user,
            //     $authenticator,
            //     $request
            // );
            return $this->redirectToRoute('app_information_email');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, TranslatorInterface $translator, UserRepository $userRepository): Response
    {
        $userEmail = $this->getUser()->getUserIdentifier();
        $user = $userRepository->findOneBy(['email' => $userEmail]);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('home');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        // $this->addFlash('success', 'Ton email à été vérifié.');

        // return $userAuthenticator->authenticateUser(
        //     $user,
        //     $authenticator,
        //     $request
        // );
        return $this->redirectToRoute('app_user_edit', ['id' => $user->getId()]);
    }
    /**
     * @Route("/register/check/email", name="app_information_email")
     */
    public function messageInformation()
    {
        return $this->render('registration/informations.html.twig');
    }
}

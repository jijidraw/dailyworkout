<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\ImagesProfiles;
use App\Entity\Notification;
use App\Entity\Team;
use App\Entity\TeamMember;
use App\Entity\TeamPost;
use App\Entity\User;
use App\Form\TeamPostType;
use App\Form\TeamType;
use App\Repository\FollowRepository;
use App\Repository\ImagesProfilesRepository;
use App\Repository\RewardRepository;
use App\Repository\TeamMemberRepository;
use App\Repository\TeamPostRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Repository\UserStatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/team")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/home", name="app_team_index", methods={"GET", "POST"})
     */
    public function mainTeam(TeamRepository $teamRepository, TeamMemberRepository $teamMemberRepository): Response
    {
        $user = $this->getUser();
        return $this->renderForm('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
            'teamsrepo' => $teamMemberRepository->findBy(['user' => $user])
        ]);
    }

    /**
     * @Route("/member/add/{id}", name="app_team_add_member", methods={"GET", "POST"})
     */
    public function addMember(UserRepository $userRepository, EntityManagerInterface $em, Team $team, TeamMemberRepository $teamMemberRepository): Response
    {
        $teamMember = new TeamMember();
        $user = $this->getUser();
        $teamMember->setTeam($team)->setUser($user)->setIsWaiting(true)->setIsAdmin(false)->setIsBlocked(false)->setIsInvite(false);
        $em->persist($teamMember);
        $em->flush();

        // notification
        $admins = $teamMemberRepository->findBy(['team' => $team, 'is_admin' => true]);
        foreach ($admins as $admin) {
            $currentUser = $this->getUser()->getUserIdentifier();
            $currentName = $userRepository->findOneBy(['email' => $currentUser]);
            $name = $currentName->getName();
            $adminUser = $admin->getUser();
            $notification = new Notification;
            $notification->setUser($adminUser)->setTeam($team)->setContent(" $name à demandé à rejoindre le groupe")->setIsRead(false);
        }

        $em->persist($notification);
        $em->flush();

        // notification

        return $this->redirectToRoute('app_team_show', ['id' => $team->getId()], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/member/{id}", name="app_team_accept_member", methods={"GET", "POST"})
     */
    public function memberValidation(TeamMember $teamMember, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $team = $teamMember->getTeam();
        $teamMember->setIsWaiting(false);
        $em->persist($teamMember);
        $em->flush();


        // notification

        $teamUser = $teamMember->getUser();
        $teamName = $teamMember->getTeam()->getName();
        $notification = new Notification;
        $notification->setUser($teamUser)->setTeam($team)->setContent(" Votre demande pour rejoindre $teamName à été validé")->setIsRead(false);
        $em->persist($notification);
        $em->flush();

        // notification

        return $this->redirectToRoute('app_team_show', ['id' => $team->getId()], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/admin/{id}", name="app_team_admin_member", methods={"GET", "POST"})
     */
    public function memberSetAdmin(TeamMember $teamMember, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $team = $teamMember->getTeam();
        $teamMember->setIsAdmin(true);
        $em->persist($teamMember);
        $em->flush();

        // notification
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $name = $currentName->getName();
        $teamUser = $teamMember->getUser();
        $teamName = $teamMember->getTeam()->getName();
        $notification = new Notification;
        $notification->setUser($teamUser)->setTeam($team)->setContent("$name vous a nommé comme admin de $teamName")->setIsRead(false);
        $em->persist($notification);
        $em->flush();

        // notification

        return $this->redirectToRoute('app_team_show', ['id' => $team->getId()], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/delete/{id}", name="app_team_delete_member", methods={"GET", "POST"})
     */
    public function memberDelete(TeamMember $teamMember, TeamMemberRepository $teamMemberRepository): Response
    {
        $team = $teamMember->getTeam();
        $teamMemberRepository->remove($teamMember, true);

        return $this->redirectToRoute('app_team_show', ['id' => $team->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/new", name="app_team_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TeamRepository $teamRepository, EntityManagerInterface $em, UserStatRepository $userStatRepository, UserRepository $userRepository, RewardRepository $rewardRepository): Response
    {
        $user = $this->getUser();
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team->setIsPrivate(false);
            $teamRepository->add($team, true);
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
                $img->setTeam($team);
                $team->setImagesProfiles($img);
            } else {
                $img = new ImagesProfiles();
                $img->setName('team.png')->setTeam($team);
            }

            $em->persist($team);
            $em->flush();
            $teamMember = new TeamMember();
            $teamMember->setIsAdmin(true)->setTeam($team)->setUser($user)->setIsWaiting(false)->setIsBlocked(false)->setIsInvite(false);
            $em->persist($teamMember);
            $em->flush();

            $userStat = $userStatRepository->findOneBy(['user' => $user]);
            $count = $userStat->getTeamCreate();
            $userStat->setTeamCreate(++$count);
            $userStatRepository->add($userStat, true);
            if ($count == 1) {
                $userIdentifier = $user->getUserIdentifier();
                $currentUser = $userRepository->findOneBy(['email' => $userIdentifier]);
                $reward = $rewardRepository->findOneBy(['id' => 8]);
                $currentUser->addReward($reward);
                $userRepository->add($currentUser, true);
            }



            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_team_show", methods={"GET", "POST"})
     */
    public function show(Team $team, TeamMemberRepository $teamMemberRepository, Request $request, TeamPostRepository $teamPostRepository, EntityManagerInterface $em, FollowRepository $followRepository): Response
    {
        $teamPost = new TeamPost();
        $postForm = $this->createForm(TeamPostType::class, $teamPost);
        $postForm->handleRequest($request);
        $user = $this->getUser();

        // recherche si l'utilisateur fait partie du groupe ou non

        $isMember = $teamMemberRepository->findOneBy(['user' => $user, 'team' => $team]);


        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $teamPost->setUser($user)->setTeam($team)->setCreatedAt(new \DateTime());
            $teamPostRepository->add($teamPost, true);
            $empty = $postForm->get('image')->getData();

            if (!empty($empty)) {
                $images = $postForm->get('image')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('post_directory'),
                    $fichier
                );
                $img = new Images();
                $img->setName($fichier);
                $teamPost->setImage($img);
            };
            $em->persist($teamPost);
            $em->flush();

            return $this->redirectToRoute('app_team_show', ['id' => $team->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team/show.html.twig', [
            'team' => $team,
            'isMember' => $teamMemberRepository->findOneBy(['user' => $user, 'team' => $team]),
            'teamsrepo' => $teamMemberRepository->findBy(['user' => $user]),
            'admins' => $teamMemberRepository->findBy(['team' => $team, 'is_admin' => true]),
            'posts' => $teamPostRepository->findBy(['team' => $team], ['created_at' => 'DESC']),
            'form' => $postForm->createView(),
            'follows' => $followRepository->findBy(['following' => $user]),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, TeamRepository $teamRepository, EntityManagerInterface $em, ImagesProfilesRepository $imagesProfilesRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $empty = $form->get('imageProfile')->getData();

            if (!empty($empty)) {
                // fonction pour effacer l'ancienne image de profil
                $userId = $team->getId();
                $ImgRmv = $imagesProfilesRepository->findOneBy(['team' => $userId]);
                if ($ImgRmv->getName() != 'team.png') {
                    $ImgRmvName = $ImgRmv->getName();
                    unlink($this->getParameter('profil_directory') . '/' . $ImgRmvName);
                    $em->remove($ImgRmv);
                    $em->flush();
                } else {
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
                $img->setTeam($team);
                $team->setImagesProfiles($img);
            };



            $teamRepository->add($team, true);

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_delete', methods: ['POST'])]
    public function delete(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $team->getId(), $request->request->get('_token'))) {
            if ($team->getImagesProfiles() != null) {
                $imgName = $team->getImagesProfiles()->getName();
                unlink($this->getParameter('profil_directory') . '/' . $imgName);
            }
            $teamRepository->remove($team, true);
        }

        return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/post/{id}', name: 'app_team_delete_post', methods: ['POST'])]
    public function deletePost(Request $request, TeamPost $teamPost, TeamPostRepository $teamRepository): Response
    {
        $team = $teamPost->getTeam();
        if ($this->isCsrfTokenValid('delete' . $teamPost->getId(), $request->request->get('_token'))) {
            if ($teamPost->getImage() != null) {
                $imgName = $teamPost->getImage()->getName();
                unlink($this->getParameter('post_directory') . '/' . $imgName);
            }
            $teamRepository->remove($teamPost, true);
        }

        return $this->redirectToRoute('app_team_show', ['id' => $team->getId()], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/invite/{id}/{user}", name="app_team_invite", methods={"GET"})
     */
    public function addTeamMember(Team $team, User $user, EntityManagerInterface $em, UserRepository $userRepository)
    {
        $currentUser = $this->getUser()->getUserIdentifier();
        $currentName = $userRepository->findOneBy(['email' => $currentUser]);
        $name = $currentName->getName();
        if ($currentName->getImagesProfiles() == null) {
            $img = null;
        } else {
            $img = $currentName->getImagesProfiles()->getName();
        };
        $teamMember = new TeamMember;
        $teamMember->setUser($user)->setTeam($team)->setIsInvite(true)->setIsBlocked(false)->setIsAdmin(false)->setIsWaiting(false);
        $em->persist($teamMember);
        $em->flush();
        $teamName = $team->getName();
        $notification = new Notification;
        if ($img == null) {
            $notification->setUser($user)->setTeam($team)->setContent("$name vous à invité à rejoindre $teamName")->setIsRead(false);
        } else {
            $notification->setUser($user)->setTeam($team)->setContent("$name vous à invité à rejoindre $teamName")->setIsRead(false)->setImage($img);
        };
        $em->persist($notification);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Invitation envoyée'
        ], 200);
    }
    /**
     * @Route("/invite/{id}", name="app_team_invite_accept", methods={"GET"})
     */
    public function acceptTeamMember(TeamMember $teamMember, EntityManagerInterface $em, UserStatRepository $userStatRepository, UserRepository $userRepository, RewardRepository $rewardRepository)
    {
        $user = $this->getUser();
        $team = $teamMember->getTeam();
        $teamMember->setIsInvite(false);
        $em->persist($teamMember);
        $em->flush();
        $userStat = $userStatRepository->findOneBy(['user' => $user]);
        $count = $userStat->getTeamMember();
        $userStat->setTeamMember(++$count);
        $userStatRepository->add($userStat, true);
        if ($count == 1) {
            $userIdentifier = $user->getUserIdentifier();
            $currentUser = $userRepository->findOneBy(['email' => $userIdentifier]);
            $reward = $rewardRepository->findOneBy(['id' => 9]);
            $currentUser->addReward($reward);
            $userRepository->add($currentUser, true);
        }
        return $this->redirectToRoute('app_team_show', ['id' => $team->getId()], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/refuse/{id}", name="app_team_invite_refuse", methods={"GET"})
     */
    public function refuseTeamMember(TeamMember $teamMember, EntityManagerInterface $em, TeamMemberRepository $teamMemberRepository)
    {
        $teamMemberRepository->remove($teamMember, true);
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}

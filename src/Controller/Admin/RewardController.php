<?php

namespace App\Controller\Admin;

use App\Entity\ImageSystem;
use App\Entity\Reward;
use App\Form\RewardType;
use App\Repository\ImageSystemRepository;
use App\Repository\RewardRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/reward")
 */
class RewardController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_reward_index", methods={"GET"})
     */
    public function index(RewardRepository $rewardRepository): Response
    {
        return $this->render('admin/reward/index.html.twig', [
            'rewards' => $rewardRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_reward_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RewardRepository $rewardRepository): Response
    {
        $reward = new Reward();
        $form = $this->createForm(RewardType::class, $reward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reward->setCreatedAt(new DateTime());
            $rewardRepository->add($reward, true);

            $empty = $form->get('imageSystem')->getData();

            if (!empty($empty)) {

                $images = $form->get('imageSystem')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('admin_directory'),
                    $fichier
                );

                $img = new ImageSystem();
                $img->setName($fichier);
                $img->setReward($reward);
                $reward->setImageSystem($img);
            };

            return $this->redirectToRoute('app_admin_reward_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/reward/new.html.twig', [
            'reward' => $reward,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_reward_show', methods: ['GET'])]
    public function show(Reward $reward): Response
    {
        return $this->render('admin/reward/show.html.twig', [
            'reward' => $reward,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_reward_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reward $reward, RewardRepository $rewardRepository, ImageSystemRepository $imageSystem, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RewardType::class, $reward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rewardRepository->add($reward, true);
            $empty = $form->get('imageSystem')->getData();

            if (!empty($empty)) {
                // fonction pour effacer l'ancienne image
                $userId = $reward->getId();
                $ImgRmv = $imageSystem->findOneBy(['reward' => $userId]);
                if (!empty($ImgRmv)) {

                    $ImgRmvName = $ImgRmv->getName();
                    unlink($this->getParameter('admin_directory') . '/' . $ImgRmvName);
                    $em->remove($ImgRmv);
                    $em->flush();
                }

                $images = $form->get('imageSystem')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('admin_directory'),
                    $fichier
                );

                $img = new ImageSystem();
                $img->setName($fichier);
                $img->setReward($reward);
                $reward->setImageSystem($img);
            };
            $em->flush();

            return $this->redirectToRoute('app_admin_reward_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/reward/edit.html.twig', [
            'reward' => $reward,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_reward_delete', methods: ['POST'])]
    public function delete(Request $request, Reward $reward, RewardRepository $rewardRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reward->getId(), $request->request->get('_token'))) {
            $rewardRepository->remove($reward, true);
        }

        return $this->redirectToRoute('app_admin_reward_index', [], Response::HTTP_SEE_OTHER);
    }
}

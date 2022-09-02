<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RewardsController extends AbstractController
{
    /**
     * @Route("/rewards", name="app_rewards")
     */
    public function index(): Response
    {
        return $this->render('rewards/index.html.twig', [
            'controller_name' => 'RewardsController',
        ]);
    }
}

<?php

namespace App\Controller\SPA;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpaDashboardController extends AbstractController
{
    #[Route('/spa/dashboard', name: 'spa_dashboard')]
    #[Route('/spa', name: 'spa_home')]
    public function index(): Response
    {
        return $this->render('spa/spa_dashboard/index.html.twig', [
            'controller_name' => 'SpaDashboardController',
            'active' => 'spa_dashboard',
        ]);
    }
}

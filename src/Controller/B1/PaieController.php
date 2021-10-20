<?php

namespace App\Controller\B1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/b1')]
class PaieController extends AbstractController
{
    #[Route('/paie', name: 'b1_paie')]
    public function index(): Response
    {
        return $this->render('b1/paie/index.html.twig', [
            'controller_name' => 'PaieController',
        ]);
    }
}

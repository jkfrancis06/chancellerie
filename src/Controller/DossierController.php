<?php

namespace App\Controller;

use App\Entity\Militaire;
use App\Entity\SousDossier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DossierController extends AbstractController
{
    #[Route('/{id}/dossiers', name: 'militaire_dossiers',methods: ['GET','POST'])]
    public function index(Request $request, Militaire $militaire): Response
    {

        return $this->render('dossier/index.html.twig', [
            'controller_name' => 'DossierController',
            'active' => 'dossier',
            'militaire' => $militaire,
        ]);
    }
}

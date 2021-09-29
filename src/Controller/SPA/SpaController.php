<?php

namespace App\Controller\SPA;

use App\Entity\Affectation;
use App\Entity\Militaire;
use App\Entity\Unite;
use App\Service\AffectationGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/spa/unite')]
class SpaController extends AbstractController
{

    private $affectationGetter;

    public function __construct(AffectationGetter $affectationGetter)
    {
        $this->affectationGetter = $affectationGetter;
    }

    #[Route('/', name: 'spa_create')]
    public function index(): Response
    {


        if ($this->getUser()->getMilitaire() != null){
            $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($this->getUser()->getMilitaire()->getId());
            $unites = $this->getDoctrine()->getManager()->getRepository(Unite::class)->findBy([
                'chefFormation' => $militaire
            ]);
        }else{
            $unites = [];
            $militaire = null;
        }



        return $this->render('spa/spa/index.html.twig', [
            'active' => 'spa_create',
            'unites' => $unites,
            'militaire' => $militaire
        ]);
    }



    #[Route('/{id}', name: 'spa_unite_create')]
    public function create(Unite $unite): Response
    {

        $militaires = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->findMilitairesFromUnites($unite);


        return $this->render('spa/spa/create.html.twig', [
            'active' => 'spa_create',
            'unite' => $unite,
            'militaires' => $militaires,
        ]);
    }
}

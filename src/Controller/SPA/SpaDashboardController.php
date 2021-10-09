<?php

namespace App\Controller\SPA;

use App\Entity\Affectation;
use App\Entity\Corps;
use App\Entity\Militaire;
use App\Entity\Spa;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpaDashboardController extends AbstractController
{
    #[Route('/spa/dashboard', name: 'spa_dashboard')]
    #[Route('/spa', name: 'spa_home')]
    public function index(): Response
    {
        $affectations_array = array();

        if ($this->getUser()->getMilitaire() != null){

            $militaire = $this->getDoctrine()->getManager()->getRepository(Militaire::class)->find($this->getUser()->getMilitaire()->getId());

            $corps = $this->getDoctrine()->getManager()->getRepository(Corps::class)->findOneBy([
                'chefCorps' => $militaire
            ]);
            if ($corps != null){


                $unites = $corps->getUnites();

                $affectations =  $this->getDoctrine()->getManager()->getRepository(Affectation::class)->findAffectationByUniteActive($unites);

                // on cherche les militaires qui sont dans ces unites a cette date donnee

                if ($affectations != null) {

                    foreach ($affectations as $affectation){

                        if (!array_key_exists($affectation->getUnite()->getId(),$affectations_array)){
                            $affectations_array[$affectation->getUnite()->getId()] = [];
                            $affectations_array[$affectation->getUnite()->getId()]['unite'] = $affectation->getUnite();
                            $affectations_array[$affectation->getUnite()->getId()]['count'] = 0;
                        }
                        $affectations_array[$affectation->getUnite()->getId()]['count']++;

                    }
                }
            }

        }else{
            $unites = [];
            $militaire = null;
            $spas = [];
        }


        return $this->render('spa/spa_dashboard/index.html.twig', [
            'controller_name' => 'SpaDashboardController',
            'active' => 'spa_dashboard',
        ]);
    }
}
